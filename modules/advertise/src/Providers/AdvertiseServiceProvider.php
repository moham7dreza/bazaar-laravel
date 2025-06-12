<?php

declare(strict_types=1);

namespace Modules\Advertise\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use Modules\Advertise\Commands\AdvertisementLadderCommand;
use Modules\Advertise\Database\Seeders\AdvertiseSeeder;

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

    public function boot(): void {}

    private function setupSeeders(): void
    {
        DatabaseSeeder::$seeders[] = AdvertiseSeeder::class;
    }
}
