<?php

namespace App\Console\Commands\System;

use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class AddChangelogEntryCommand extends Command
{
    protected $signature = 'changelog';

    protected $description = 'Add a new entry to the changelog file following the project guidelines';

    protected array $authors = [
        'Mohamadreza Rezaei',
    ];

    protected array $categories = [
        'Added',
        'Updated',
        'Fixed',
        'Deprecated',
        'Removed',
    ];

    protected array $impacts = [
        'High',
        'Medium',
        'Low',
        'None',
    ];

    public function handle(): void
    {
        $this->info('=== Adding New Changelog Entry ===');
        $this->line('Please provide the following details for the changelog entry.');
        $this->line('Refer to the project guidelines:');
        $this->warn('- Be clear and concise');
        $this->warn('- Focus on what changed');
        $this->warn('- Use Consistent Language');
        $this->warn('- Include relevant details like Jira tickets or MR links');
        $this->newLine();

        // Get and validate datetime
        $datetime = null;
        $currentDatetime = Carbon::now()->format('Y-m-d H:i');

        while ($datetime === null) {
            $datetimeInput = text(
                label: 'Date and time [YYYY-MM-DD HH:MM]',
                default: $currentDatetime,
                validate: fn ($value) => match (true) {
                    ! empty($value) && ! Carbon::canBeCreatedFromFormat($value, 'Y-m-d H:i') => 'Invalid format. Please use YYYY-MM-DD HH:MM format (e.g. 2023-12-31 14:30)',
                    default => null
                }
            );

            try {
                $datetime = empty($datetimeInput)
                    ? Carbon::now()
                    : Carbon::createFromFormat('Y-m-d H:i', $datetimeInput);
            } catch (Exception $e) {
                error('Invalid datetime format. Please try again.');
                $datetime = null;
            }
        }

        // Get entry details with strict validation
        $title = text(
            label: 'Title of the change',
            placeholder: 'Be specific about what changed',
            required: true,
            validate: fn ($value) => match (true) {
                empty(trim($value)) => 'Title cannot be empty',
                default => null
            }
        );

        $author = suggest(
            label: 'Author',
            options: $this->authors,
            placeholder: 'Start typing to search authors...',
            required: true
        );

        $category = select(
            label: 'Category',
            options: $this->categories,
            default: 'Updated'
        );

        $impact = select(
            label: 'Impact',
            options: $this->impacts,
            default: 'Medium'
        );

        $jiraTicket = text(
            label: 'Jira Ticket',
            placeholder: 'PROJ-123 or full URL (leave empty if none)',
            validate: fn ($value) => match (true) {
                ! empty($value) && ! $this->isValidJiraTicket($value) => 'Invalid Jira ticket format. Use PROJ-123 or full Jira URL',
                default => null
            }
        );

        $mergeRequest = text(
            label: 'Merge Request URL or number',
            placeholder: '5072 or full URL (leave empty if none)',
            validate: fn ($value) => match (true) {
                ! empty($value) && ! $this->isValidMergeRequest($value) => 'Invalid format. Use MR number or full GitLab MR URL',
                default => null
            }
        );

        info('Description Guidelines:');
        warning('- Clearly explain what changed in 1-3 sentences');
        warning('- Mention any affected components (API endpoints, DB tables, etc.)');
        warning('- Note any breaking changes if impact is High');

        $description = text(
            label: 'Description of the change',
            placeholder: 'Describe what changed and why...',
            required: true,
            validate: fn ($value) => match (true) {
                empty(trim($value)) => 'Description cannot be empty',
                default => null
            }
        );

        // Format the entry
        $formattedDatetime = $datetime->format('Y-m-d H:i');
        $entry = "\n\n### [$formattedDatetime] - $title\n\n";
        $entry .= "- **Author**: $author\n";
        $entry .= "- **Category**: $category\n";
        $entry .= "- **Impact**: $impact\n";
        $entry .= '- **Jira Ticket**: '.$this->formatJiraTicket($jiraTicket)."\n";
        $entry .= '- **Merge Request**: '.$this->formatMergeRequest($mergeRequest)."\n";
        $entry .= "\n$description\n";
        $entry .= "\n---";

        // Show preview and confirm
        info('Changelog Entry Preview:');
        info($entry);

        $confirmed = confirm(
            label: 'Do you want to commit this changelog entry?',
            yes: 'Yes, save it',
            no: 'No, discard it'
        );

        if (! $confirmed) {
            warning('Changelog entry was NOT saved.');

            return;
        }

        // Append to changelog file
        $changelogPath = base_path('CHANGELOG.md');

        if (! File::exists($changelogPath)) {
            error('CHANGELOG.md file not found in project root!');

            return;
        }

        File::append($changelogPath, $entry);
        info('Successfully added new changelog entry!');
    }

    protected function isValidJiraTicket($input): bool
    {
        // Check for ticket format (PROJ-123)
        if (preg_match('/^[A-Za-z]+-\d+$/', $input)) {
            return true;
        }

        // Check for Jira URL format
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return (bool) preg_match('/\/browse\/[A-Za-z]+-\d+$/', $input);
        }

        return false;
    }

    protected function isValidMergeRequest($input): bool
    {
        // Check for MR number format (digits only)
        if (is_numeric($input)) {
            return true;
        }

        // Check for GitLab MR URL format
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return (bool) preg_match('/\/merge_requests\/\d+/', $input);
        }

        return false;
    }

    protected function formatJiraTicket($input): string
    {
        if (empty($input)) {
            return '-';
        }

        // If it's already a URL, return as is
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return $input;
        }

        // If it's in PROJ-123 format, convert to URL
        if (preg_match('/^([A-Za-z]+)-(\d+)$/', $input, $matches)) {
            $project = $matches[1];
            $ticket = $matches[2];

            return "https://your-jira-domain.com/browse/{$project}-{$ticket}";
        }

        return $input;
    }

    protected function formatMergeRequest($input): string
    {
        if (empty($input)) {
            return '-';
        }

        // Extract MR number if URL provided
        if (preg_match('/merge_requests\/(\d+)/', $input, $matches)) {
            $mrNumber = $matches[1];

            return "[!$mrNumber](https://github.com/moham7dreza/bazaar-laravel/pull/$mrNumber)";
        }

        // If numeric, format as MR link
        if (is_numeric($input)) {
            return "[!$input](https://github.com/moham7dreza/bazaar-laravel/pull/$input)";
        }

        return $input;
    }
}
