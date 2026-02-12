<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

class CreateTaskDocumentation extends Command
{
    protected $signature = 'make:task-doc {--branch= : Branch name (auto-detected if not provided)}';

    protected $description = 'Create standardized task documentation using interactive prompts';

    public function handle(): int
    {
        $this->info('📝 Task Documentation Generator');
        $this->newLine();

        // Get current branch name
        $branchName = $this->option('branch') ?? $this->getCurrentBranch();

        if ( ! $branchName)
        {
            $this->error('Could not detect branch name. Please provide it with --branch option.');

            return self::FAILURE;
        }

        $this->info("Current branch: {$branchName}");
        $this->newLine();

        // Extract Jira ticket from branch name
        $jiraTicket = $this->extractJiraTicket($branchName);

        if ( ! $jiraTicket)
        {
            $this->warn('Could not auto-detect Jira ticket from branch name.');
            $jiraTicket = text(
                label: 'What is the Jira ticket number?',
                placeholder: 'e.g., BACKEND-100',
                required: true,
                validate: fn (string $value) => match (true)
                {
                    ! preg_match('/^[A-Z]+-\d+$/', $value) => 'Invalid Jira ticket format (e.g., BACKEND-100)',
                    default                                => null
                }
            );
        } else
        {
            $this->info("Detected Jira ticket: {$jiraTicket}");
        }

        // Gather documentation metadata
        $taskTitle = text(
            label: 'What is the task title?',
            placeholder: 'e.g., Implement Order Processing System',
            required: true
        );

        $taskType = select(
            label: 'What type of task is this?',
            options: [
                'feature'     => 'Feature',
                'bug'         => 'Bug Fix',
                'enhancement' => 'Enhancement',
                'refactor'    => 'Refactor',
                'other'       => 'Other',
            ],
            default: 'feature'
        );

        $module = text(
            label: 'Which module does this affect?',
            placeholder: 'e.g., Payment, Booking, User Management',
            required: true
        );

        $priority = select(
            label: 'What is the priority?',
            options: [
                'low'      => 'Low',
                'medium'   => 'Medium',
                'high'     => 'High',
                'critical' => 'Critical',
            ],
            default: 'medium'
        );

        // Business Context
        $this->newLine();
        $this->info('📊 Business Context');
        $this->newLine();

        $businessProblem = textarea(
            label: 'What business problem does this solve?',
            placeholder: 'Explain the problem or opportunity this addresses...',
            required: true
        );

        $impactedUsers = multiselect(
            label: 'Who does this impact?',
            options: [
                'property_owners' => 'Property Owners',
                'guests'          => 'Guests/Renters',
                'admin'           => 'Admin Panel Users',
                'support'         => 'Customer Support Team',
                'finance'         => 'Finance/Accounting Team',
                'other'           => 'Other',
            ],
            required: true
        );

        $businessRules = textarea(
            label: 'List the key business rules implemented (one per line)',
            placeholder: "1. Seasonal rates can only be set for future dates\n2. Maximum 20 seasonal rate periods per property",
            required: true
        );

        // Technical Details
        $this->newLine();
        $this->info('🛠️  Technical Details');
        $this->newLine();

        $backendRoutes = textarea(
            label: 'List backend routes (format: METHOD /path - Description)',
            placeholder: "POST /api/v1/properties/{id}/rates - Create seasonal rate\nGET /api/v1/properties/{id}/rates - List seasonal rates",
            required: false
        );

        $keyFiles = textarea(
            label: 'List key files created/modified (one per line)',
            placeholder: "app/Http/Controllers/API/V1/SeasonalRateController.php\napp/Models/SeasonalRate.php",
            required: false
        );

        $databaseChanges = textarea(
            label: 'Describe database changes (high-level)',
            placeholder: 'New table: seasonal_rates. Added index on property_id.',
            required: false
        );

        $integrationPoints = textarea(
            label: 'Integration points with other modules/systems',
            placeholder: 'Integrates with Payment Module for price calculation',
            required: false
        );

        // Testing
        $this->newLine();
        $this->info('🧪 Testing');
        $this->newLine();

        $testsCreated = textarea(
            label: 'What tests were created?',
            placeholder: "tests/Feature/SeasonalRateAPITest.php\ntests/Unit/SeasonalRateTest.php",
            required: false
        );

        // Optional links
        $this->newLine();
        $this->info('🔗 Optional Links');
        $this->newLine();

        $jiraUrl = text(
            label: 'Jira ticket URL (optional)',
            placeholder: 'https://jira.your-company.com/browse/BACKEND-100',
            required: false
        );

        $confluenceUrl = text(
            label: 'Confluence documentation URL (optional)',
            placeholder: 'https://confluence.your-company.com/...',
            required: false
        );

        $apiDocsUrl = text(
            label: 'API documentation URL (optional)',
            placeholder: 'https://your-app.test/docs/api',
            required: false
        );

        // Additional notes
        $additionalNotes = textarea(
            label: 'Any additional notes or context?',
            placeholder: 'Optional additional information...',
            required: false
        );

        // Generate filename
        $fileName = $this->generateFileName($jiraTicket, $taskTitle);
        $filePath = base_path("docs/features/{$fileName}");

        // Check if file already exists
        if (File::exists($filePath))
        {
            $overwrite = confirm(
                label: "File {$fileName} already exists. Overwrite?",
                default: false
            );

            if ( ! $overwrite)
            {
                $this->warn('Documentation creation cancelled.');

                return self::SUCCESS;
            }
        }

        // Generate documentation content
        $content = $this->generateDocumentation([
            'jiraTicket'        => $jiraTicket,
            'branchName'        => $branchName,
            'taskTitle'         => $taskTitle,
            'taskType'          => $taskType,
            'module'            => $module,
            'priority'          => $priority,
            'businessProblem'   => $businessProblem,
            'impactedUsers'     => $impactedUsers,
            'businessRules'     => $businessRules,
            'backendRoutes'     => $backendRoutes,
            'keyFiles'          => $keyFiles,
            'databaseChanges'   => $databaseChanges,
            'integrationPoints' => $integrationPoints,
            'testsCreated'      => $testsCreated,
            'jiraUrl'           => $jiraUrl,
            'confluenceUrl'     => $confluenceUrl,
            'apiDocsUrl'        => $apiDocsUrl,
            'additionalNotes'   => $additionalNotes,
        ]);

        // Save the file
        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, $content);

        $this->newLine();
        $this->info('✅ Documentation created successfully!');
        $this->info("📄 File: {$filePath}");
        $this->newLine();
        $this->info('Next steps:');
        $this->info('1. Review and enhance the generated documentation');
        $this->info('2. Add any missing details');
        $this->info('3. Commit the documentation with your code changes');
        $this->newLine();

        return self::SUCCESS;
    }

    protected function getCurrentBranch(): ?string
    {
        try
        {
            $branch = mb_trim(shell_exec('git rev-parse --abbrev-ref HEAD 2>/dev/null') ?? '');

            return '' !== $branch ? $branch : null;
        } catch (Exception)
        {
            return null;
        }
    }

    protected function extractJiraTicket(string $branchName): ?string
    {
        if (preg_match('/([A-Z]+-\d+)/', $branchName, $matches))
        {
            return $matches[1];
        }

        return null;
    }

    protected function generateFileName(string $jiraTicket, string $taskTitle): string
    {
        $slug = Str::slug($taskTitle);

        return "{$jiraTicket}-{$slug}.md";
    }

    protected function generateDocumentation(array $data): string
    {
        $impactedUsersFormatted = $this->formatImpactedUsers($data['impactedUsers']);
        $currentDate            = now()->format('Y-m-d');
        $currentUser            = get_current_user();

        $jiraLink          = $data['jiraUrl'] ?: '[TODO: Add Jira URL]';
        $confluenceLink    = $data['confluenceUrl'] ?: 'N/A';
        $apiDocsLink       = $data['apiDocsUrl'] ?: 'N/A';
        $databaseChanges   = $data['databaseChanges'] ?: '[TODO: Describe database modifications]';
        $integrationPoints = $data['integrationPoints'] ?: '[TODO: List external systems or modules this integrates with]';
        $additionalNotes   = $data['additionalNotes'] ?: 'N/A';

        return <<<MD
# {$data['taskTitle']}

> **Documentation for**: {$data['jiraTicket']}
> **Author**: {$currentUser}
> **Date**: {$currentDate}
> **Branch**: `{$data['branchName']}`

---

## 📋 Metadata

| Field | Value |
|-------|-------|
| **Jira Ticket** | [{$data['jiraTicket']}]({$jiraLink}) |
| **Branch Name** | `{$data['branchName']}` |
| **Task Type** | {$data['taskType']} |
| **Module** | {$data['module']} |
| **Priority** | {$data['priority']} |
| **Confluence Docs** | {$confluenceLink} |
| **API Documentation** | {$apiDocsLink} |

---

## 🎯 Business Context

### What Problem Does This Solve?

{$data['businessProblem']}

### Who Does This Impact?

{$impactedUsersFormatted}

### Business Rules Implemented

{$data['businessRules']}

---

## 🔄 User Workflows

### Primary User Flow

[TODO: Describe the main user journey step-by-step]

1. **Step 1**: [User action and system response]
2. **Step 2**: [User action and system response]
3. **Step 3**: [User action and system response]

### Alternative Flows

[TODO: Describe alternative paths users might take]

### Error Scenarios

[TODO: What happens when things go wrong?]

---

## 🛠️ Technical Implementation

### Backend Routes

{$this->formatBackendRoutes($data['backendRoutes'])}

### Key Files Changed

{$this->formatKeyFiles($data['keyFiles'])}

### Database Changes

{$databaseChanges}

### Integration Points

{$integrationPoints}

### Validation Rules

[TODO: Add key validation rules]

---

## 🧪 Testing

### Test Coverage

{$this->formatTests($data['testsCreated'])}

### Test Scenarios Covered

[TODO: List test scenarios]

1. ✅ [Test scenario 1]
2. ✅ [Test scenario 2]

### How to Run Tests

```bash
php artisan test --filter={$data['jiraTicket']}
```

---

## 🔐 Security Considerations

[TODO: Document security aspects]

- **Authorization**: [Describe authorization checks]
- **Validation**: [Describe validation approach]
- **Rate Limiting**: [If applicable]

---

## 📊 Performance Considerations

[TODO: Document performance implications]

- **Database Queries**: [Optimization strategies]
- **Caching**: [Caching strategy]
- **Indexing**: [Database indexes added]

---

## 🚀 Deployment Notes

### Environment Variables

[TODO: List new environment variables if any]

```env
# Add new environment variables here
```

### Configuration Changes

[TODO: List config files that need updates]

### Migration Notes

```bash
php artisan migrate
```

**Rollback Strategy:**
```bash
php artisan migrate:rollback --step=1
```

---

## 📚 Related Documentation

[TODO: Add links to related documentation]

- [API Documentation]({$apiDocsLink})
- [Confluence Documentation]({$confluenceLink})

---

## ⚠️ Known Issues / Limitations

[TODO: List any known limitations or future improvements needed]

1. [Known issue or limitation]

---

## 🔄 Rollback Plan

1. Revert merge commit: `git revert [commit-hash]`
2. Run migration rollback (if applicable)
3. Clear cache: `php artisan cache:clear`
4. Restart workers: `php artisan queue:restart`

---

## ✅ Definition of Done Checklist

- [ ] All acceptance criteria from Jira ticket met
- [ ] Code reviewed and approved
- [ ] Tests written and passing
- [ ] Documentation completed
- [ ] No new security vulnerabilities introduced
- [ ] Performance tested under expected load
- [ ] PM/Product team approved business logic

---

## 📝 Additional Notes

{$additionalNotes}

---

## 🔗 Quick Links

- [Jira Ticket]({$jiraLink})
- [Confluence Documentation]({$confluenceLink})
- [API Documentation]({$apiDocsLink})

---

*This documentation was created on {$currentDate} by {$currentUser} for task {$data['jiraTicket']}.*

MD;
    }

    protected function formatImpactedUsers(array $users): string
    {
        $userLabels = [
            'property_owners' => 'Property Owners',
            'guests'          => 'Guests/Renters',
            'admin'           => 'Admin Panel Users',
            'support'         => 'Customer Support Team',
            'finance'         => 'Finance/Accounting Team',
            'other'           => 'Other',
        ];

        $formatted = [];
        foreach ($users as $user)
        {
            $formatted[] = "- [x] {$userLabels[$user]}";
        }

        return implode("\n", $formatted);
    }

    protected function formatBackendRoutes(?string $routes): string
    {
        if ( ! $routes)
        {
            return '[TODO: List backend routes created/modified]';
        }

        $lines     = explode("\n", mb_trim($routes));
        $formatted = "| Method | Route | Description | Auth Required |\n";
        $formatted .= "|--------|-------|-------------|---------------|\n";

        foreach ($lines as $line)
        {
            $line = mb_trim($line);
            if (empty($line))
            {
                continue;
            }

            // Try to parse: METHOD /path - Description
            if (preg_match('/^(GET|POST|PUT|PATCH|DELETE)\s+(.+?)\s+-\s+(.+)$/', $line, $matches))
            {
                $formatted .= "| {$matches[1]} | `{$matches[2]}` | {$matches[3]} | [TODO] |\n";
            } else
            {
                $formatted .= "| [TODO] | `{$line}` | [TODO] | [TODO] |\n";
            }
        }

        return $formatted;
    }

    protected function formatKeyFiles(?string $files): string
    {
        if ( ! $files)
        {
            return '[TODO: List main files created or significantly modified]';
        }

        $lines     = explode("\n", mb_trim($files));
        $formatted = [];

        foreach ($lines as $line)
        {
            $line = mb_trim($line);
            if ( ! empty($line))
            {
                $formatted[] = "- `{$line}`";
            }
        }

        return implode("\n", $formatted);
    }

    protected function formatTests(?string $tests): string
    {
        if ( ! $tests)
        {
            return '[TODO: List test files created]';
        }

        $lines     = explode("\n", mb_trim($tests));
        $formatted = [];

        foreach ($lines as $line)
        {
            $line = mb_trim($line);
            if ( ! empty($line))
            {
                $formatted[] = "- [ ] `{$line}`";
            }
        }

        return implode("\n", $formatted);
    }
}
