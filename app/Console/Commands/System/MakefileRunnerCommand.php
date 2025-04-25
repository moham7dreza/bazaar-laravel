<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

class MakefileRunnerCommand extends Command
{
    protected $signature = 'make:run';
    protected $description = 'Search and run Makefile scripts';

    public function handle()
    {
        $makefilePath = base_path('makefile');

        if (! File::exists($makefilePath)) {
            $this->error('makefile not found in project root!');

            return 1;
        }

        $scripts = $this->parseMakefile(File::get($makefilePath));

        if (empty($scripts)) {
            $this->error('No scripts found in makefile!');

            return 1;
        }

        $mode = select(
            label: 'Select search mode',
            options: [
                'search' => 'Search',
                'list' => 'List',
            ],
            default: 'search'
        );

        $selectedScript = $mode === 'search'
            ? $this->searchScripts($scripts)
            : $this->listScripts($scripts);

        $this->runScript($selectedScript);
    }

    protected function parseMakefile(string $content): array
    {
        $scripts = [];
        $currentScript = null;
        $currentDescription = '';

        foreach (explode("\n", $content) as $line) {
            $trimmed = trim($line);

            // Skip empty lines
            if ($trimmed === '') {
                continue;
            }

            // Found a new target
            if (preg_match('/^([a-zA-Z0-9_-]+):/', $trimmed, $matches)) {
                // Save previous script if exists
                if ($currentScript !== null) {
                    $scripts[$currentScript] = trim($currentDescription);
                }

                $currentScript = $matches[1];
                $currentDescription = '';

                // Check for inline comment
                if (preg_match('/#\s*(.+)$/', $trimmed, $commentMatches)) {
                    $currentDescription = $commentMatches[1];
                }
            }
            // Found a comment line
            elseif (str_starts_with($trimmed, '#')) {
                $currentDescription .= ' '.substr($trimmed, 1);
            }
        }

        // Add the last script
        if ($currentScript !== null) {
            $scripts[$currentScript] = trim($currentDescription);
        }

        return $scripts;
    }

    protected function searchScripts(array $scripts): string
    {
        return search(
            label: 'Search for a script to run',
            options: fn (string $value) => empty($value)
                ? array_keys($scripts) // Show all when empty
                : array_values(
                    array_filter(
                        array_keys($scripts),
                        fn ($script) => str_contains(strtolower($script), strtolower($value))
                    )
                ),
            placeholder: 'E.g. test, build...',
            scroll: 10
        );
    }

    protected function listScripts(array $scripts): string
    {
        $options = [];
        foreach ($scripts as $script => $desc) {
            $options[$script] = empty($desc) ? $script : "$script - $desc";
        }

        return select(
            label: 'Select a script to run',
            options: $options,
            scroll: 10
        );
    }

    protected function runScript(string $script)
    {
        $this->info("Running: make $script");
        $this->newLine();

        passthru("make $script", $result);

        $this->newLine();
        $this->info("Finished with exit code: $result");
    }
}
