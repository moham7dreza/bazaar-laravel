<?php

declare(strict_types=1);

namespace Modules\Advertise\Providers;

use Database\Seeders\DatabaseSeeder;
use Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Advertise\Commands\AdvertisementLadderCommand;
use Modules\Advertise\Database\Seeders\AdvertiseSeeder;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Policies\AdvertisementPolicy;

final class AdvertiseServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [
        AdvertisementLadderCommand::class,
    ];

    public function register(): void
    {
        $this->commands(self::COMMANDS);

        $this->setupSeeders();
    }

    public function boot(): void
    {
        $this->configurePolicies();
    }

    private function setupSeeders(): void
    {
        DatabaseSeeder::$seeders[] = AdvertiseSeeder::class;
    }

    private function configurePolicies(): void
    {
        Gate::policy(Advertisement::class, AdvertisementPolicy::class);
    }
}
