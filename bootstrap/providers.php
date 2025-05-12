<?php

declare(strict_types=1);

return [
    Amiriun\SMS\SMSServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\CommandLoggingServiceProvider::class,
    App\Providers\FakerServiceProvider::class,
    Modules\Filament\Providers\SuperAdminPanelProvider::class,
    App\Providers\HealthServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\JobLoggingServiceProvider::class,
    App\Providers\PrometheusServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Tests\TestsServiceProvider::class,
];
