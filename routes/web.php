<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

Route::get('/', function () {
    return <<<'blade'
        <div style="display: flex;flex-direction: column;gap: 1rem;font-size: 2rem;">
            <a href="/docs/api">api docs</a>
            <a href="/log-viewer">log viewer</a>
            <a href="/health?fresh">health</a>
            <a href="/pulse">pulse</a>
            <a href="/telescope">telescope</a>
        </div>
    blade;
});

Route::get('health', HeathCheckControllers\HealthCheckResultsController::class);
Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class);

// Route::get('image', [ImageController::class, 'index']);
// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__ . '/auth.php';
