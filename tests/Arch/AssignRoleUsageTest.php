<?php

declare(strict_types=1);

/**
 * This test fails if any test file directly calls assignRole or syncRoles on the User model.
 *
 * Tests should use helper functions like asUser() or asAdminUser() instead of
 * calling assignRole/syncRoles directly on User instances.
 */
test('no test should call assignRole or syncRoles on User model directly', function (): void {
    $testsPath = base_path('tests');

    // Use single grep with extended regex for better performance
    $output = shell_exec("grep -rnE -- '->(assignRole|syncRoles)' {$testsPath} 2>/dev/null");

    if ( ! $output)
    {
        expect([])->toBe([]); // No violations found

        return;
    }

    $lines      = array_filter(explode("\n", $output), fn ($line) => ! empty(mb_trim($line)));
    $violations = [];

    foreach ($lines as $line)
    {
        if ( ! preg_match('/^([^:]+):(\d+):(.+)$/', $line, $matches))
        {
            continue;
        }

        [$_, $file, $lineNumber, $content] = $matches;
        $relativePath                      = str_replace($testsPath . '/', '', $file);
        $trimmedContent                    = mb_trim($content);

        // Skip this test file itself
        if (str_contains($relativePath, 'AssignRoleUsageTest.php'))
        {
            continue;
        }

        // Skip legitimate helper functions and utilities
        if (shouldSkipLine($relativePath, $trimmedContent))
        {
            continue;
        }

        $violations[] = [
            'file' => $relativePath,
            'line' => $lineNumber,
            'code' => $trimmedContent,
        ];
    }

    if (empty($violations))
    {
        expect([])->toBe([]);

        return;
    }

    $message = buildViolationMessage($violations);
    expect($violations)->toBe([], $message);
});

function shouldSkipLine(string $file, string $content): bool
{
    // Skip comments
    return preg_match('/^\s*(?:\/\/|\*|#)/', $content);
}

function buildViolationMessage(array $violations): string
{
    $count   = count($violations);
    $message = "Found {$count} violation(s) where assignRole or syncRoles is called directly on User model.\n";
    $message .= "Use helper functions like asUser() or asAdminUser() instead.\n\n";
    $message .= "Violations:\n";

    foreach ($violations as $violation)
    {
        $message .= sprintf(
            "  %s:%s\n    %s\n\n",
            $violation['file'],
            $violation['line'],
            $violation['code']
        );
    }

    return mb_rtrim($message);
}
