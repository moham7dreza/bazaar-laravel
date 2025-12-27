<?php

declare(strict_types=1);

namespace App\Concerns\Console;

use Closure;
use Illuminate\Support\Facades\Concurrency;
use Spatie\Async\Pool;
use Throwable;

trait WithAsyncTasks
{
    protected function runConcurrently(array $tasks): array
    {
        return Concurrency::run($tasks);
    }

    protected function runAsync(array $tasks, int $concurrency = 20): array
    {
        $pool    = Pool::create()->concurrency($concurrency);
        $results = [];

        foreach ($tasks as $key => $task)
        {
            $pool->add($task)->then(function ($output) use (&$results, $key): void {
                $results[$key] = $output;
            })->catch(function (Throwable $e) use (&$results, $key): void {
                $results[$key] = ['error' => $e->getMessage()];
            });
        }

        $pool->wait();

        return $results;
    }

    protected function parallel(array $closures): array
    {
        return Concurrency::run($closures);
    }

    protected function defer(Closure $callback): void
    {
        Concurrency::defer($callback);
    }
}
