<?php

declare(strict_types=1);

use App\Http\Controllers\DomainRouterController;
use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SyncRolePermissionsController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::fallback(FallbackController::class);

Route::get('/', HomeController::class)
    ->name('web.welcome');

Route::middleware([

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

when(app()->isLocal(), function (): void {
    Route::get('/toon-benchmark', function () {
        $json        = json_decode(file_get_contents(base_path('pint.json')), true);
        $jsonEncoded = json_encode($json, JSON_PRETTY_PRINT);
        $toonEncoded = Toon::convert($json);

        return [
            'json_size'      => mb_strlen($jsonEncoded),
            'toon_size'      => mb_strlen($toonEncoded),
            'saving_percent' => 100 - (mb_strlen($toonEncoded) / mb_strlen($jsonEncoded) * 100),
        ];
    });
});
