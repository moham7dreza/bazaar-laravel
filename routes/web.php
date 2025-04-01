<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

Route::get('/', function () {
    mongo_info('view', ['ip' => request()->ip(), 'url' => request()->url()], true);
    return <<<'blade'
        <div style="display: flex;flex-direction: column;gap: 1rem;font-size: 2rem;">
            <a href="/docs/api">api docs</a>
            <a href="/log-viewer">log viewer</a>
            <a href="/health?fresh">health</a>
            <a href="/pulse">pulse</a>
            <a href="/telescope">telescope</a>
            <a href="/horizon">horizon</a>
            <a href="/metrics">metrics</a>
        </div>
    blade;
});

Route::can('viewHealth')->middleware([])->group(function () {
    Route::get('health', HeathCheckControllers\HealthCheckResultsController::class);
    Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class);
});


// Route::get('image', [ImageController::class, 'index']);
// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__ . '/auth.php';
