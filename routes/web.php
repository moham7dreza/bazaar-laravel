<?php

use App\Http\Controllers\DomainRouterController;
use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RolePermissionsController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

Route::fallback(FallbackController::class);

Route::get('/', [HomeController::class, 'index'])->name('web.welcome');

Route::middleware([
    \App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
    \App\Http\Middleware\CheckAdminMiddleware::class,
])
    ->group(function () {

        Route::put('permissions/update', [RolePermissionsController::class, 'update'])->name('web.permissions.update');

        Route::get('domain-router', DomainRouterController::class)->name('web.domain-router');

        Route::can('viewHealth')->group(function () {

            Route::get('health', HeathCheckControllers\HealthCheckResultsController::class);
            Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class);
            Route::get('health-custom', HealthCheckController::class)->name('web.health-custom');
        });
    });

Route::get('image', [ImageController::class, 'index']);
Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__.'/auth.php';
