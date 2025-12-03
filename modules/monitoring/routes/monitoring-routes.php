<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Monitoring\Http\Controllers\HealthCheckController;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

Route::middleware([

])
    ->group(function (): void {
        Route::can('viewHealth')->group(function (): void {
            Route::get('health', HeathCheckControllers\HealthCheckResultsController::class)
                ->name('monitoring.health');
            Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class)
                ->name('monitoring.health-json');
            Route::get('health-custom', HealthCheckController::class)
                ->name('monitoring.health-custom');
        });
    });
