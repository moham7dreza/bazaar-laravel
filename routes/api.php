<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Advertise\CategoryController;
use App\Http\Controllers\Admin\Advertise\AdvertisementController;
use App\Http\Controllers\Admin\Advertise\CategoryValueController;
use App\Http\Controllers\Admin\Advertise\CategoryAttributeController;
use App\Http\Controllers\App\Panel\AdvertisementController as PanelAdvertisementController;
use App\Http\Controllers\App\Panel\AdvertisementNoteController;
use App\Http\Controllers\App\Panel\FavoriteAdvertisementController;

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('send-otp', [RegisteredUserController::class, 'sendOtp'])->middleware('guest');
Route::post('verify-otp', [RegisteredUserController::class, 'verifyOtpAndRegister'])->middleware('guest');


Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('advertise')->name('advertise.')->group(function () {
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('category-attribute', CategoryAttributeController::class);
        Route::apiResource('category-value', CategoryValueController::class);
        Route::apiResource('advertisement', AdvertisementController::class);
    });

    Route::prefix('content')->name('content.')->group(function () {
        Route::apiResource('menu', MenuController::class);
        Route::apiResource('page', PageController::class);
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::apiResource('user', UserController::class);
    });
});


//user panel
Route::prefix('panel')->name('panel.')->middleware(['auth:sanctum', 'mobileVerified'])->group(function () {
    Route::prefix('advertise')->name('advertise.')->group(function () {
        Route::apiResource('advertisement', PanelAdvertisementController::class);

        Route::prefix('notes')->name('notes.')->group(function () {

            Route::post('{advertisement}/store', [AdvertisementNoteController::class, 'store'])->name('store');
            Route::get('/', [AdvertisementNoteController::class, 'index'])->name('index');
            Route::get('{advertisement}/show', [AdvertisementNoteController::class, 'show'])->name('show');
            Route::delete('{advertisement}/destroy', [AdvertisementNoteController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('favorites')->name('favorites.')->group(function () {

        Route::get('/', [FavoriteAdvertisementController::class, 'index'])->name('index');
        Route::post('/{advertisement}', [FavoriteAdvertisementController::class, 'store'])->name('store');
        Route::delete('/{advertisement}', [FavoriteAdvertisementController::class, 'destroy'])->name('destroy');
    });
});


// Route::post('image/store', [ImageController::class, 'store'])->name('image.store');
