<?php

use App\Enums\RouteSection;
use App\Http\Controllers\Admin\Advertise\AdvertisementController;
use App\Http\Controllers\Admin\Advertise\CategoryAttributeController;
use App\Http\Controllers\Admin\Advertise\CategoryController;
use App\Http\Controllers\Admin\Advertise\CategoryValueController;
use App\Http\Controllers\Admin\Advertise\GalleryController;
use App\Http\Controllers\Admin\Advertise\StateController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\App\Home\AdvertisementController as HomeAdvertisementController;
use App\Http\Controllers\App\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\App\Home\CityController;
use App\Http\Controllers\App\Home\MenuController as HomeMenuController;
use App\Http\Controllers\App\Home\PageController as HomePageController;
use App\Http\Controllers\App\Home\StateController as HomeStateController;
use App\Http\Controllers\App\Panel\AdvertisementController as PanelAdvertisementController;
use App\Http\Controllers\App\Panel\AdvertisementNoteController;
use App\Http\Controllers\App\Panel\FavoriteAdvertisementController;
use App\Http\Controllers\App\Panel\GalleryController as PanelGalleryController;
use App\Http\Controllers\App\Panel\HistoryAdvertisementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegisteredUserWithOTPController;
use App\Http\Controllers\Auth\VerifyUserWithOTPController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$mobileVerified = ['auth:sanctum', 'mobileVerified'];

Route::get('user', static fn (Request $request) => $request->user())->middleware($mobileVerified)->name('user.info');

Route::get('categories', [HomeCategoryController::class, 'index'])->name('categories.index');
Route::get('menus', [HomeMenuController::class, 'index'])->name('menus.index');
Route::get('pages', [HomePageController::class, 'index'])->name('pages.index');
Route::get('advertisements', [HomeAdvertisementController::class, 'index'])->name('advertisements.index');
Route::get('advertisements/{advertisement}', [HomeAdvertisementController::class, 'show'])->name('advertisements.show');
Route::get('states', [HomeStateController::class, 'index'])->name('states.index');
Route::get('cities', [CityController::class, 'index'])->name('cities.index');

Route::prefix(RouteSection::AUTH)
    ->middleware('guest')
    ->name('auth.')
    ->group(function () {

        Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
        Route::post('send-otp', [RegisteredUserWithOTPController::class, 'store'])->name('send-otp');
        Route::post('verify-otp', [VerifyUserWithOTPController::class, 'store'])->name('verify-otp');
    });

Route::prefix(RouteSection::IMAGES)
    ->name('images.')
    ->group(function () {

        Route::post('store', [ImageController::class, 'store'])->name('store');
        Route::put('update', [ImageController::class, 'update'])->name('destroy');
    });

Route::prefix(RouteSection::ADMIN)
    ->name('admin.')
    ->middleware([/* 'auth', 'admin' */])
    ->group(function () {

        Route::prefix(RouteSection::ADVERTISE)
            ->name('advertise.')
            ->group(function () {

                Route::apiResource('category', CategoryController::class);
                Route::apiResource('gallery', GalleryController::class);
                Route::apiResource('state', StateController::class);
                Route::apiResource('category-attribute', CategoryAttributeController::class);
                Route::apiResource('category-value', CategoryValueController::class);
                Route::apiResource('advertisement', AdvertisementController::class);
            });

        Route::prefix(RouteSection::CONTENT)
            ->name('content.')
            ->group(function () {

                Route::apiResource('menu', MenuController::class);
                Route::apiResource('page', PageController::class);
            });

        Route::prefix(RouteSection::USERS)
            ->name('users.')
            ->group(function () {

                Route::apiResource('user', UserController::class);
            });
    });

// user panel
Route::prefix(RouteSection::PANEL)
    ->name('panel.')
    ->middleware($mobileVerified)
    ->group(function () {

        Route::prefix(RouteSection::ADVERTISE)
            ->name('advertise.')
            ->group(function () {

                Route::apiResource('advertisement', PanelAdvertisementController::class);

                Route::prefix(RouteSection::GALLERY)
                    ->name('gallery.')
                    ->group(function () {

                        Route::get('{advertisement}/', [PanelGalleryController::class, 'index'])->name('index');
                        Route::post('{advertisement}/store', [PanelGalleryController::class, 'store'])->name('store');
                        Route::get('show/{gallery}', [PanelGalleryController::class, 'show'])->name('show');
                        Route::put('/{gallery}', [PanelGalleryController::class, 'update'])->name('update');
                        Route::delete('/{gallery}', [PanelGalleryController::class, 'destroy'])->name('destroy');
                    });

                Route::prefix(RouteSection::NOTES)
                    ->name('notes.')
                    ->group(function () {

                        Route::post('{advertisement}/store', [AdvertisementNoteController::class, 'store'])->name('store');
                        Route::get('/', [AdvertisementNoteController::class, 'index'])->name('index');
                        Route::get('{advertisement}/show', [AdvertisementNoteController::class, 'show'])->name('show');
                        Route::delete('{advertisement}/destroy', [AdvertisementNoteController::class, 'destroy'])->name('destroy');
                    });
            });

        Route::prefix(RouteSection::FAVORITES)
            ->name('favorites.')
            ->group(function () {

                Route::get('/', [FavoriteAdvertisementController::class, 'index'])->name('index');
                Route::post('/{advertisement}', [FavoriteAdvertisementController::class, 'store'])->name('store');
                Route::delete('/{advertisement}', [FavoriteAdvertisementController::class, 'destroy'])->name('destroy');
            });

        Route::prefix(RouteSection::HISTORY)
            ->name('history.')
            ->group(function () {

                Route::get('/', [HistoryAdvertisementController::class, 'index'])->name('index');
                Route::post('/{advertisement}', [HistoryAdvertisementController::class, 'store'])->name('store');
            });
    });
