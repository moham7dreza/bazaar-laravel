<?php

declare(strict_types=1);

namespace App\Concerns\Console;

use Closure;
use Illuminate\Support\Sleep;

use function Laravel\Prompts\spin;

trait WithSpinner
{
    protected function withSpinner(string $message, Closure $callback): mixed
    {
        return spin(
            callback: $callback,
            message: $message
        );
    }

    protected function spinWhile(string $message, Closure $condition, int $intervalMs = 100): void
    {
        spin(
            callback: function () use ($condition, $intervalMs): void {
                while ($condition())
                {
                    Sleep::usleep($intervalMs * 1000);
                }
            },
            message: $message
        );
    }
}
