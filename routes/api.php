<?php

use App\Enums\RouteSection;
use App\Http\Controllers\Admin\Advertise\CategoryController;
use App\Http\Controllers\Admin\Content\MenuController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix(RouteSection::ADMIN)->name('admin.')->group(function () {
    Route::prefix(RouteSection::ADVERTISE)->name('advertise.')->group(function () {
        Route::apiResource('category', CategoryController::class);
    });

    Route::prefix(RouteSection::CONTENT)->name('content.')->group(function () {
        Route::apiResource('menu', MenuController::class);
    });
});
