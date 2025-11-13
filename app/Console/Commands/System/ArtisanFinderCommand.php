<?php

declare(strict_types=1);

namespace App\Console\Commands\System;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use JsonException;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class ArtisanFinderCommand extends Command
{
    protected $signature = 'find';

    protected $description = 'Find artisan commands';

    /**
     * @throws JsonException
     */
    public function handle(): int
    {
        $method = select(
            label: 'Method',
            options: [
                'Search',
                'Exact Match',
            ],
            default: 'Search'
        );

        $commands    = collect($this->getApplication()?->all());
        $commandName = $this->getSuggestedCommandName($method, $commands);

        if ( ! $this->isCommandValid($commands, $commandName))
        {
            error('Command not found.');

            return self::FAILURE;
        }

        $command = $commands->get($commandName);
        if ( ! $command)
        {
            error('Command definition not found.');

            return self::FAILURE;
        }

        if ( ! $this->confirmCommandClassPath($command))
        {
            return self::FAILURE;
        }

        $commandParameters = $this->getCommandParameters($command);
        info('Command parameters: ' . json_encode($commandParameters, JSON_THROW_ON_ERROR));

        if ( ! confirm('Do you want to continue?'))
        {
            warning('Command execution cancelled.');

            return self::FAILURE;
        }

        try
        {
            $this->call($commandName, $commandParameters);

            warning('Command execution successfully.');
        } catch (Exception $exception)
        {
            report($exception);
        }

        return self::SUCCESS;
    }

    private function getSuggestedCommandName(string $method, Collection $commands): string
    {
        $input = 'Exact Match' === $method ? text('Search part of command') : null;

        $commandsTitles = $commands->keys()
            ->reject(fn (string $command) => $command === $this->signature)
            ->when($input, fn (Collection $commands) => $commands->filter(fn ($command) => $this->matchesSearchTerms($command, $input)))
            ->values()
            ->all();

        return suggest(
            'Search for a command',
            options: $commandsTitles,
            required: true,
            hint: 'Type parts of a command name to search for'
        );
    }

    private function matchesSearchTerms(string $command, string $input): bool
    {
        return array_all(explode(' ', $input), fn ($term) => str_contains($command, (string) $term));
    }

    private function isCommandValid($commands, $commandName): bool
    {
        return $commands->keys()->contains($commandName);
    }

    private function confirmCommandClassPath($command): bool
    {
        $commandClass = $command::class;
        info("Command: {$command->getName()}");
        warning("Class: {$commandClass}");

        if ($command->getDescription())
        {
            info("Description: {$command->getDescription()}");
        }

        return confirm('Do you want to continue?');
    }

    private function getCommandParameters($command): array
    {
        $definition = $command->getDefinition();
        $arguments  = $definition->getArguments();
        $options    = $definition->getOptions();

        $placeholderText = $this->buildPlaceholderText($arguments, $options);
        $userValues      = $this->getUserInput($placeholderText);

        return $this->mapUserInputToCommandParameters($userValues, $arguments, $options);
    }

    private function buildPlaceholderText($arguments, $options): string
    {
        $argsList    = implode(' ', array_map(static fn ($arg) => $arg->getName() . ($arg->isRequired() ? '*' : ''), $arguments));
        $optionsList = implode(' ', array_map(static fn ($opt) => '--' . $opt->getName() . ($opt->isValueRequired() ? '*' : ''), $options));

        return mb_trim("{$argsList} {$optionsList}");
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

        foreach (array_keys($arguments) as $index => $argName)
        {
            $argValue = $userValues[$index] ?? null;
            if ( ! in_array($argValue, [null, '-', ''], true))
            {
                $commandParameters[$argName] = str_contains((string) $argValue, ',') ? explode(',', (string) $argValue) : $argValue;
            }
        }

        foreach (array_keys($options) as $index => $optName)
        {
            $optionValue = $userValues[count($arguments) + $index] ?? null;
            if ( ! in_array($optionValue, [null, '-', ''], true))
            {
                $commandParameters['--' . $optName] = str_contains((string) $optionValue, ',') ? explode(',', (string) $optionValue) : $optionValue;
            }
        }

        return $commandParameters;
    }
}
