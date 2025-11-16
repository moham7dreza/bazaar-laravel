<?php

declare(strict_types=1);

use App\Http\Controllers\DomainRouterController;
use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SyncRolePermissionsController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

when(app()->isLocal(), function (): void {
});

Route::fallback(FallbackController::class);

Route::get('/', HomeController::class)
    ->name('web.welcome');

Route::middleware([
    /*
    App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
    App\Http\Middleware\CheckAdminMiddleware::class,
    */
])
    ->group(function (): void {
        Route::view('tool', 'tool')
            ->name('web.tool');
        Route::put('role-permissions-sync', SyncRolePermissionsController::class)
            ->name('web.permissions.sync');
        Route::get('domain-router', DomainRouterController::class)
            ->name('web.domain-router');
    });

Route::prefix('image')
    ->controller(ImageController::class)
    ->group(function (): void {
        Route::get('/', 'index')
            ->name('web.image.index');
        Route::post('store', 'store')
            ->name('web.image.store');
    });
