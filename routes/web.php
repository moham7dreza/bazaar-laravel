<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Route::get('image', [ImageController::class, 'index']);
// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__ . '/auth.php';
