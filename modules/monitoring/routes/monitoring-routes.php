<?php

declare(strict_types=1);

use Modules\Monitoring\Http\Controllers\HealthCheckController;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

Route::middleware([
    /*
    App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
    App\Http\Middleware\CheckAdminMiddleware::class,
    */
])
    ->group(function (): void {

        Route::can('viewHealth')->group(function (): void {

            Route::get('health', HeathCheckControllers\HealthCheckResultsController::class);
//            Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class);
//            Route::get('health-custom', HealthCheckController::class)->name('web.health-custom');
        });
    });
