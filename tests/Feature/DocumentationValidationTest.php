<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

/**
 * Documentation Validation Tests.
 *
 * These tests enforce that task documentation exists for feature branches
 * and follows the required structure.
 */
it('requires documentation for feature branches', function (): void {
    $branchName = mb_trim(shell_exec('git rev-parse --abbrev-ref HEAD') ?? '');

    // Skip validation for main/master/develop branches
    if (in_array($branchName, ['main', 'master', 'develop', 'HEAD']))
    {
        expect(true)->toBeTrue();

        return;
    }

    // Skip if not a feature/bugfix/enhancement branch
    if ( ! preg_match('/^(feature|bugfix|enhancement|hotfix)\//', $branchName))
    {
        expect(true)->toBeTrue();

        return;
    }

    // Extract Jira ticket from branch name
    preg_match('/([A-Z]+-\d+)/', $branchName, $matches);

    if ( ! isset($matches[1]))
    {
        $this->markTestSkipped("Could not extract Jira ticket from branch: {$branchName}");

        return;
    }

    $jiraTicket = $matches[1];

    // Check if documentation file exists
    $docsPath = base_path('docs/features');
    $files    = File::glob("{$docsPath}/{$jiraTicket}-*.md");

    expect($files)
        ->not->toBeEmpty("Documentation file not found for {$jiraTicket}. Please create documentation using 'php artisan make:task-doc' or the AI prompt template.");
})->group('documentation');

it('validates documentation contains required metadata sections', function (): void {
    $docsPath = base_path('docs/features');
    $files    = File::files($docsPath);

    if (empty($files))
    {
        $this->markTestSkipped('No documentation files to validate');

        return;
    }

    // Validate the most recently created documentation file
    $latestFile = collect($files)->sortByDesc(fn ($file) => $file->getMTime())->first();
    $content    = File::get($latestFile->getPathname());

    // Required sections (using regex to handle emojis)
    $requiredSections = [
        '/##\s+.*Metadata/',
        '/##\s+.*Business Context/',
        '/##\s+.*Technical Implementation/',
        '/##\s+.*Testing/',
    ];

    foreach ($requiredSections as $pattern)
    {
        expect($content)
            ->toMatch($pattern, "Documentation missing required section matching: {$pattern}");
    }
})->group('documentation');

it('validates documentation contains Jira ticket link', function (): void {
    $docsPath = base_path('docs/features');
    $files    = File::files($docsPath);

    if (empty($files))
    {
        $this->markTestSkipped('No documentation files to validate');

        return;
    }

    // Validate the most recently created documentation file
    $latestFile = collect($files)->sortByDesc(fn ($file) => $file->getMTime())->first();
    $content    = File::get($latestFile->getPathname());

    // Should contain Jira ticket reference
    expect($content)
        ->toMatch('/\*\*Jira Ticket\*\*.*\[([A-Z]+-\d+)\]/', 'Documentation must include Jira ticket link in metadata table');
})->group('documentation');

it('validates documentation contains branch name', function (): void {
    $docsPath = base_path('docs/features');
    $files    = File::files($docsPath);

    if (empty($files))
    {
        $this->markTestSkipped('No documentation files to validate');

        return;
    }

    // Validate the most recently created documentation file
    $latestFile = collect($files)->sortByDesc(fn ($file) => $file->getMTime())->first();
    $content    = File::get($latestFile->getPathname());

    // Should contain branch name
    expect($content)
        ->toMatch('/Branch Name/', 'Documentation must include branch name in metadata table');
})->group('documentation');

it('validates documentation file naming convention', function (): void {
    $docsPath = base_path('docs/features');
    $files    = File::files($docsPath);

    if (empty($files))
    {
        $this->markTestSkipped('No documentation files to validate');

        return;
    }

    foreach ($files as $file)
    {
        $filename = $file->getFilename();

        // Skip template files
        if (str_contains($filename, 'TEMPLATE'))
        {
            continue;
        }

        // Validate naming convention: JIRA-XXX-description.md
        expect($filename)
            ->toMatch('/^[A-Z]+-\d+-.+\.md$/', "Documentation file '{$filename}' does not follow naming convention: JIRA-XXX-description.md");
    }
})->group('documentation');

it('ensures documentation template exists', function (): void {
    $templatePath = base_path('docs/templates/TASK_DOCUMENTATION_TEMPLATE.md');

    expect(File::exists($templatePath))
        ->toBeTrue('Documentation template not found at docs/templates/TASK_DOCUMENTATION_TEMPLATE.md');
})->group('documentation');

it('ensures AI prompt template exists', function (): void {
    $promptPath = base_path('.github/DOCUMENTATION_AI_PROMPT.md');

    expect(File::exists($promptPath))
        ->toBeTrue('AI documentation prompt not found at .github/DOCUMENTATION_AI_PROMPT.md');
})->group('documentation');
