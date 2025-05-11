<?php

declare(strict_types=1);

namespace Modules\Auth\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Database\Seeders\AuthSeeder;

final class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->setupSeeders();
    }

    public function boot(): void
    {
    }

    private function setupSeeders(): void
    {
        DatabaseSeeder::$seeders[] = AuthSeeder::class;
    }
}
