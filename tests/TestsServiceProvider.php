<?php

namespace Tests;

use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\ServiceProvider;

class TestsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if ($this->isRunningTestsInParallel()) {
            ParallelTesting::setUpTestCase(function ($testCase, int $token) {});
        }
    }

    private function isRunningTestsInParallel(): bool
    {
        return ($this->app->runningUnitTests() && ! empty($_SERVER['LARAVEL_PARALLEL_TESTING'])) ||
            ($this->app->runningInConsole() && in_array('--parallel', $_SERVER['argv'], true));
    }
}
