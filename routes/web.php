<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return <<<'blade'
        <div style="display: flex;flex-direction: column;gap: 1rem;font-size: 2rem;">
            <a href="/dosc/api">api docs</a>
            <a href="/log-viewer">log viewer</a>
        </div>
    blade;
});

// Route::get('image', [ImageController::class, 'index']);
// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__ . '/auth.php';
