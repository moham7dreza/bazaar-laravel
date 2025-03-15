<?php

use App\Enums\RouteSection;
use App\Http\Controllers\Admin\Advertise;
use App\Http\Controllers\Admin\Content;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix(RouteSection::ADMIN)->name('admin.')->group(function () {
    Route::prefix(RouteSection::ADVERTISE)->name('advertise.')->group(function () {
        Route::apiResource('category', Advertise\CategoryController::class);
    });

    Route::prefix(RouteSection::CONTENT)->name('content.')->group(function () {
        Route::apiResource('menu', Content\MenuController::class);
        Route::apiResource('page', Content\PageController::class);
    });
});
