<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Redis\LimiterTimeoutException;
use Illuminate\Support\Facades\Redis;

class EmailRateLimit
{
    /**
     * @throws LimiterTimeoutException
     */
    public function handle($job, Closure $next): void
    {
        Redis::throttle('email-throttle')
            ->block(2)
            ->allow(10)
            ->every(2)
            ->then(
                function () use ($job, $next): void {
                    $next($job);
                },
                function () use ($job): void {
                    $job->release(30);
                }
            );
    }
}
