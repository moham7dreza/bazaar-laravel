<?php

declare(strict_types=1);

use App\Enums\RouteSection;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\App\Home\CityController;
use App\Http\Controllers\ImageController;
use App\Http\Middleware\EnsureMobileIsVerified;
use App\Http\Middleware\MetricsLoggerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Advertise\Http\Controllers\Admin\AdvertisementController;
use Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController;
use Modules\Advertise\Http\Controllers\Admin\CategoryController;
use Modules\Advertise\Http\Controllers\Admin\CategoryValueController;
use Modules\Advertise\Http\Controllers\Admin\GalleryController;
use Modules\Advertise\Http\Controllers\Admin\StateController;
use Modules\Advertise\Http\Controllers\App\AdvertisementController as HomeAdvertisementController;
use Modules\Advertise\Http\Controllers\App\CategoryController as HomeCategoryController;
use Modules\Advertise\Http\Controllers\App\StateController as HomeStateController;
use Modules\Advertise\Http\Controllers\Panel\AdvertisementController as PanelAdvertisementController;
use Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController;
use Modules\Advertise\Http\Controllers\Panel\FavoriteAdvertisementController;
use Modules\Advertise\Http\Controllers\Panel\GalleryController as PanelGalleryController;
use Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController;
use Modules\Auth\Http\Controllers\RegisteredUserWithOTPController;
use Modules\Auth\Http\Controllers\VerifyUserWithOTPController;
use Modules\Content\Http\Controllers\Admin\MenuController;
use Modules\Content\Http\Controllers\Admin\PageController;
use Modules\Content\Http\Controllers\App\MenuController as HomeMenuController;
use Modules\Content\Http\Controllers\App\PageController as HomePageController;

when(isEnvStaging(), function (): void {

    Route::view('test', 'test');
});

Route::get('user', static fn (Request $request) => $request->user())->name('user.info')
    ->middleware(['auth:sanctum', 'mobileVerified']);

Route::get('categories', [HomeCategoryController::class, 'index'])->name('categories.index');
Route::get('menus', [HomeMenuController::class, 'index'])->name('menus.index');
Route::get('pages', [HomePageController::class, 'index'])->name('pages.index');

Route::prefix(RouteSection::ADVERTISEMENTS)
    ->controller(HomeAdvertisementController::class)
    ->middleware('cache-response:120')
    ->group(function (): void {

        Route::get('/', 'index')->name('advertisements.index');
        Route::get('{advertisement}', 'show')->name('advertisements.show')
            ->withTrashed();
    });

Route::get('states', [HomeStateController::class, 'index'])->name('states.index');
Route::get('cities', [CityController::class, 'index'])->name('cities.index');

Route::prefix(RouteSection::AUTH)
    ->middleware('guest')
    ->name('auth.')
    ->group(function (): void {

        Route::post('send-otp', RegisteredUserWithOTPController::class)->name('send-otp')
            ->middleware(['throttle:10,1', MetricsLoggerMiddleware::class]);
        Route::post('verify-otp', VerifyUserWithOTPController::class)->name('verify-otp')
            ->middleware('throttle:5,1');
    });

Route::prefix(RouteSection::IMAGES)
    ->controller(ImageController::class)
    ->name('images.')
    ->group(function (): void {

        Route::post('store', 'store')->name('store');
        Route::put('update', 'update')->name('destroy');
    });

Route::prefix(RouteSection::ADMIN)
    ->name('admin.')
    ->middleware([/* 'auth', 'admin' */])
    ->group(function (): void {

        Route::prefix(RouteSection::ADVERTISE)
            ->name('advertise.')
            ->group(function (): void {

                Route::apiResource('category', CategoryController::class);
                Route::apiResource('gallery', GalleryController::class);
                Route::apiResource('state', StateController::class);
                Route::apiResource('category-attribute', CategoryAttributeController::class);
                Route::apiResource('category-value', CategoryValueController::class);
                Route::apiResource('advertisement', AdvertisementController::class)
                    ->withTrashed();
            });

        Route::prefix(RouteSection::CONTENT)
            ->name('content.')
            ->group(function (): void {

                Route::apiResource('menu', MenuController::class);
                Route::apiResource('page', PageController::class);
            });

        Route::prefix(RouteSection::USERS)
            ->name('users.')
            ->group(function (): void {

                Route::apiResource('user', UserController::class)
                    ->except('store');
            });
    });

// user panel
Route::prefix(RouteSection::PANEL)
    ->name('panel.')
    ->middleware([
        'auth:sanctum',
        EnsureMobileIsVerified::class,
    ])
    ->group(function (): void {

        Route::prefix(RouteSection::ADVERTISE)
            ->name('advertise.')
            ->group(function (): void {

                Route::apiResource('advertisement', PanelAdvertisementController::class)
                    ->withTrashed(['show', 'update']);

                Route::prefix(RouteSection::GALLERY)
                    ->name('gallery.')
                    ->group(function (): void {

                        Route::get('{advertisement}', [PanelGalleryController::class, 'index'])->name('index');
                        Route::post('{advertisement}/store', [PanelGalleryController::class, 'store'])->name('store');
                        Route::get('show/{gallery}', [PanelGalleryController::class, 'show'])->name('show')
                            ->withTrashed();
                        Route::put('{gallery}', [PanelGalleryController::class, 'update'])->name('update')
                            ->withTrashed();
                        Route::delete('{gallery}', [PanelGalleryController::class, 'destroy'])->name('destroy');
                    });

                Route::prefix(RouteSection::NOTES)
                    ->controller(AdvertisementNoteController::class)
                    ->name('notes.')
                    ->group(function (): void {

                        Route::post('{advertisement}/store', 'store')->name('store');
                        Route::get('/', 'index')->name('index');
                        Route::get('{advertisement}/show', 'show')->name('show')
                            ->withTrashed();
                        Route::delete('{advertisement}/destroy', 'destroy')->name('destroy');
                    });
            });

        Route::prefix(RouteSection::FAVORITES)
            ->controller(FavoriteAdvertisementController::class)
            ->name('favorites.')
            ->group(function (): void {

                Route::get('/', 'index')->name('index');
                Route::post('{advertisement}', 'store')->name('store');
                Route::delete('{advertisement}', 'destroy')->name('destroy');
            });

        Route::prefix(RouteSection::HISTORY)
            ->controller(HistoryAdvertisementController::class)
            ->name('history.')
            ->group(function (): void {

                Route::get('/', 'index')->name('index');
                Route::post('{advertisement}', 'store')->name('store');
            });
    });
