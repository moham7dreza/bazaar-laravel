<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class ArtisanFinderCommand extends Command
{
    protected $signature = 'find:art {--exact}';
    protected $description = 'Find artisan command with given name';

    public function handle(): int
    {
        $commands = collect($this->getApplication()?->all());
        $commandName = $this->getSuggestedCommandName($commands);

        if (!$this->isCommandValid($commands, $commandName)) {
            $this->error("Command not found.");
            return Command::FAILURE;
        }

        $command = $commands->get($commandName);
        if (!$command) {
            $this->error("Command definition not found.");
            return Command::FAILURE;
        }

        if (!$this->confirmCommandClassPath($command)) {
            return Command::FAILURE;
        }

        $commandParameters = $this->getCommandParameters($command);
        dump(compact('commandParameters'));

        if (!$this->confirm('Do you want to continue?', true)) {
            $this->warn("Command execution cancelled.");
            return Command::FAILURE;
        }

        try {
            $this->call($commandName, $commandParameters);

            $this->warn("Command execution successfully.");
        } catch (\Exception $exception) {
            report($exception);
        }

        return Command::SUCCESS;
    }

    private function getSuggestedCommandName(Collection $commands): string
    {
        $input = $this->option('exact') ? $this->ask('Search part of command') : null;

        $commandsTitles = $commands->keys()
            ->reject(fn (string $command) => $command === $this->signature)
            ->when($this->option('exact') && $input, function (Collection $commands) use ($input) {
                return $commands->filter(fn ($command) => $this->matchesSearchTerms($command, $input));
            })
            ->values()
            ->toArray();

        return suggest(
            'Search for a command',
            options: $commandsTitles,
            required: true,
            hint: 'Type parts of a command name to search for'
        );
    }

    private function matchesSearchTerms(string $command, string $input): bool
    {
        foreach (explode(' ', $input) as $term) {
            if (!str_contains($command, $term)) {
                return false;
            }
        }
        return true;
    }

    private function isCommandValid($commands, $commandName): bool
    {
        return $commands->keys()->contains($commandName);
    }

    private function confirmCommandClassPath($command): bool
    {
        $commandClass = get_class($command);
        $this->warn("Command Class Path: $commandClass");
        return $this->confirm('Do you want to continue?', true);
    }

    private function getCommandParameters($command): array
    {
        $definition = $command->getDefinition();
        $arguments = $definition->getArguments();
        $options = $definition->getOptions();

        $placeholderText = $this->buildPlaceholderText($arguments, $options);
        $userValues = $this->getUserInput($placeholderText);

        return $this->mapUserInputToCommandParameters($userValues, $arguments, $options);
    }

    private function buildPlaceholderText($arguments, $options): string
    {
        $argsList = implode(' ', array_map(static fn ($arg) => $arg->getName() . ($arg->isRequired() ? '*' : ''), $arguments));
        $optionsList = implode(' ', array_map(static fn ($opt) => '--' . $opt->getName() . ($opt->isValueRequired() ? '*' : ''), $options));
        return trim("$argsList $optionsList");
    }

    private function getUserInput(string $placeholderText): array
    {
        $argsInput = text(
            label: 'Write arguments:',
            placeholder: $placeholderText,
            hint: '*Required args - Press Enter for none. Use - for empty args, Set options as true/false in order.',
        );
        return explode(' ', $argsInput);
    }

    private function mapUserInputToCommandParameters(array $userValues, $arguments, $options): array
    {
        $commandParameters = [];

        foreach (array_keys($arguments) as $index => $argName) {
            $argValue = $userValues[$index] ?? null;
            if (!in_array($argValue, [null, '-', ''], true)) {
                $commandParameters[$argName] = str_contains($argValue, ',') ? explode(',', $argValue) : $argValue;
            }
        }

        foreach (array_keys($options) as $index => $optName) {
            $optionValue = $userValues[count($arguments) + $index] ?? null;
            if (!in_array($optionValue, [null, '-', ''], true)) {
                $commandParameters['--' . $optName] = str_contains($optionValue, ',') ? explode(',', $optionValue) : $optionValue;
            }
        }

        return $commandParameters;
    }
}
