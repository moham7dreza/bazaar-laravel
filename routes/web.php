<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers as HeathCheckControllers;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::can('viewHealth')->middleware(['admin', 'dev'])->group(function () {
    Route::get('health', HeathCheckControllers\HealthCheckResultsController::class);
    Route::get('health-json', HeathCheckControllers\HealthCheckJsonResultsController::class);
});

// Route::get('image', [ImageController::class, 'index']);
// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');

require __DIR__.'/auth.php';
