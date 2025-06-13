<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Str;

final readonly class ReportFormatter
{
    // Output: +----------------------------+
    public function createSeparatorLine(int $length = 50)
    {
        return sprintf(
            '%s%s%s',
            '+',
            Str::repeat('-', $length - 2),
            '+'
        );
    }

    // Output: [███████░░░] 70%
    public function formatProgressBar(int $completed, int $total = 10)
    {
        $progress  = Str::repeat('█', $completed);
        $remaining = Str::repeat('░', $total - $completed);

        return sprintf(
            '[%s%s] %d%%',
            $progress,
            $remaining,
            ($completed / $total) * 100
        );
    }

    // Output:       -
    public function createIndentation(int $level)
    {
        return sprintf(
            '%s%s',
            Str::repeat('  ', $level),
            '- '
        );
    }
}
