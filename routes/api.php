<?php

use App\Http\Controllers\Admin\Advertise\CategoryAttributeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Advertise\CategoryController;
use App\Http\Controllers\Admin\Advertise\CategoryValueController;

// Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('advertise')->name('advertise.')->group(function () {
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('category-attribute', CategoryAttributeController::class);
        Route::apiResource('category-value', CategoryValueController::class);
    });

    Route::prefix('content')->name('content.')->group(function () {
        Route::apiResource('menu', MenuController::class);
        Route::apiResource('page', PageController::class);
    });
});


// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');
