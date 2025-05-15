<?php

declare(strict_types=1);

test('Using DatabaseTransactions trait directly is forbidden', function (): void {
    $output = shell_exec('grep -lr DatabaseTransactions ' . base_path('tests'));
    $files  = explode("\n", $output);

    $files = array_filter($files, fn ($file) => '' !== $file && ! preg_match("/(TestsGlobalRulesTest|Pest\.php)/", $file));

    expect($files)->toBe([]);
});
