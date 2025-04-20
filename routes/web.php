<?php

use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\DomainRouter;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

$private = ['admin', 'dev'];

Route::fallback([HomeController::class, 'fallbackHandler']);

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::middleware($private)
    ->name('web.domain-router')
    ->get('domain-router', function () {

        $routes = app(DomainRouter::class)->generateRoutes(request());

        return ApiJsonResponse::success('routes', $routes);
    });

Route::can('viewHealth')
    ->middleware($private)
    ->group(function () {

        Route::get('health', HeathCheckControllers\HealthCheckResultsController::class);
        Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class);
        Route::get('health-custom', [HealthCheckController::class, 'check']);
    });

// Route::get('image', [ImageController::class, 'index']);
// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__.'/auth.php';
