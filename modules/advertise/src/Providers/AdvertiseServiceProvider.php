<?php

declare(strict_types=1);

namespace Modules\Advertise\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Advertise\Commands\AdvertisementLadderCommand;

final class AdvertiseServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [
        AdvertisementLadderCommand::class,
    ];

    public function register(): void
    {
        $this->commands(self::COMMANDS);
    }

    public function boot(): void
    {
    }
}
