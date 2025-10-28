<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

final class TestsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->configureParallelTests();

        $this->configureTestResponse();
    }

    private function configureParallelTests(): void
    {
        if ($this->isRunningTestsInParallel())
        {
            ParallelTesting::setUpTestCase(function ($testCase, int $token): void {
            });
        }
    }

    private function configureTestResponse(): void
    {
        TestResponse::macro('assertApiJsonResponseStructure', fn (array $data) => $this->assertJsonStructure([
            'data' => $data,
            'meta' => [
                'status',
                'messages',
            ],
        ]));
    }

    private function isRunningTestsInParallel(): bool
    {
        return ($this->app->runningUnitTests() && ! empty(Request::server('LARAVEL_PARALLEL_TESTING'))) ||
            ($this->app->runningInConsole() && in_array('--parallel', Request::server('argv'), true));
    }
}
