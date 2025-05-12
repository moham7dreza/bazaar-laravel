<?php

declare(strict_types=1);

use App\Http\Controllers\DomainRouterController;
use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SyncRolePermissionsController;
use Illuminate\Support\Facades\Route;

Route::fallback(FallbackController::class);

Route::get('/', HomeController::class)->name('web.welcome');

Route::middleware([
    App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
    App\Http\Middleware\CheckAdminMiddleware::class,
])
    ->group(function (): void {

        Route::view('tool', 'tool')->name('web.tool');

        Route::put('role-permissions-sync', SyncRolePermissionsController::class)->name('web.permissions.sync');

        Route::get('domain-router', DomainRouterController::class)->name('web.domain-router');
    });

Route::get('image', [ImageController::class, 'index']);
Route::post('image/store', [ImageController::class, 'store'])->name('image.store');
