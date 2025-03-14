<?php

use App\Http\Controllers\Admin\Advertise\CategoryController;
use App\Http\Controllers\Admin\Content\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('advertise')->name('advertise.')->group(function () {
        Route::apiResource('category', CategoryController::class);
    });

    Route::prefix('content')->name('content.')->group(function () {
        Route::apiResource('menu', MenuController::class);
    });
});
