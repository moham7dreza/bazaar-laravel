<?php

declare(strict_types=1);

namespace Modules\Content\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use Modules\Content\Database\Seeders\ContentSeeder;

final class ContentServiceProvider extends ServiceProvider
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
        DatabaseSeeder::$seeders[] = ContentSeeder::class;
    }
}
