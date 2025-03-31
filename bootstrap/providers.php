<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\HealthServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Tests\TestsServiceProvider::class,
    \Amiriun\SMS\SMSServiceProvider::class,
    \App\Providers\CommandLoggingServiceProvider::class,
    \App\Providers\JobLoggingServiceProvider::class,
];
