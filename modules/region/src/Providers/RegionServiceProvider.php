<?php

declare(strict_types=1);

namespace Modules\Region\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use Override;
use Sadegh19b\LaravelIranCities\Seeders\IranCitiesSeeder;

class RegionServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
    }

    public function boot(): void
    {
        DatabaseSeeder::$seeders[] = IranCitiesSeeder::class;
    }
}
