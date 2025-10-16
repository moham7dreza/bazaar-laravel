<?php

declare(strict_types=1);

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
use Modules\Advertise\Http\Controllers\App\AdvertisementGalleryController as HomeAdvertisementGalleryController;
use Modules\Advertise\Http\Controllers\App\CategoryAttributeController as HomeCategoryAttributeController;
use Modules\Advertise\Http\Controllers\App\CategoryController as HomeCategoryController;
use Modules\Advertise\Http\Controllers\App\CategoryValueController as HomeCategoryValueController;
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

when(isEnvLocal(), function (): void {
    Route::post('idempotency', fn () => logger('idempotency passed'))
        ->middleware(Infinitypaul\Idempotency\Middleware\EnsureIdempotency::class)
        ->name('idempotency');

    Route::get('lock-test', fn () => print 1)->block(
        lockSeconds: 5,
        waitSeconds: 5,
    );
});

when(isEnvLocalOrTesting(), function (): void {
    Route::get('today/{date}', fn ($date) => $date)->name('today.date');
});

Route::get('user', static fn (Request $request) => $request->user())->name('user.info')
    ->middleware(['auth:sanctum', 'mobile-verified']);

/*
|--------------------------------------------------------------------------
| Primary Routes
|--------------------------------------------------------------------------
*/
Route::get('categories', [HomeCategoryController::class, 'index'])->name('categories.index');
Route::get('menus', [HomeMenuController::class, 'index'])->name('menus.index');
Route::get('pages', [HomePageController::class, 'index'])->name('pages.index');
Route::get('states', [HomeStateController::class, 'index'])->name('states.index');
Route::get('cities', [CityController::class, 'index'])->name('cities.index');
/*
|--------------------------------------------------------------------------
| Advertisement Routes
|--------------------------------------------------------------------------
*/
Route::prefix('advertisements')
    ->name('advertisements.')
    ->middleware('cache-response:120')
    ->group(function (): void {
        Route::controller(HomeAdvertisementController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('{advertisement}', 'show')->name('show')
                    ->withTrashed();
            });
        Route::controller(HomeAdvertisementGalleryController::class)
            ->group(function (): void {
                Route::get('{advertisement}/gallery', 'index')->name('gallery.index');
            });
        Route::prefix('category')
            ->group(function (): void {
                Route::get('{category}/attributes', HomeCategoryAttributeController::class)->name('category.attributes.index');
                Route::get('{categoryAttribute}/values', HomeCategoryValueController::class)->name('category.values.index');
            });
    });
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')
    ->name('auth.')
    ->middleware([
        'guest',
        'throttle:10,1',
    ])
    ->group(function (): void {
        Route::post('send-otp', RegisteredUserWithOTPController::class)->name('send-otp')
            ->middleware(MetricsLoggerMiddleware::class);
        Route::post('verify-otp', VerifyUserWithOTPController::class)->name('verify-otp');
    });
/*
|--------------------------------------------------------------------------
| Image Routes
|--------------------------------------------------------------------------
*/
Route::prefix('images')
    ->name('images.')
    ->controller(ImageController::class)
    ->group(function (): void {
        Route::post('store', 'store')->name('store');
        Route::put('update', 'update')->name('destroy');
    });
/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware([/* 'auth', 'admin' */])
    ->group(function (): void {
        /*
        |--------------------------------------------------------------------------
        | Advertisements Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('advertisements')
            ->name('advertisements.')
            ->group(function (): void {
                Route::apiResource('category', CategoryController::class);
                Route::apiResource('{advertisement}/gallery', GalleryController::class);
                Route::apiResource('state', StateController::class);
                Route::apiResource('category-attribute', CategoryAttributeController::class);
                Route::apiResource('category-value', CategoryValueController::class);
                Route::apiResource('advertisement', AdvertisementController::class)
                    ->withTrashed();
            });
        /*
        |--------------------------------------------------------------------------
        | Content Section Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('content')
            ->name('content.')
            ->group(function (): void {
                Route::apiResource('menu', MenuController::class);
                Route::apiResource('page', PageController::class);
            });
        /*
        |--------------------------------------------------------------------------
        | Users Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('users')
            ->name('users.')
            ->group(function (): void {
                Route::apiResource('user', UserController::class);
            });
    });

/*
|--------------------------------------------------------------------------
| User Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('panel')
    ->name('panel.')
    ->middleware([
        'auth:sanctum',
        EnsureMobileIsVerified::class,
    ])
    ->group(function (): void {
        /*
        |--------------------------------------------------------------------------
        | Advertisements Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('advertisements')
            ->name('advertisements.')
            ->group(function (): void {
                Route::apiResource('advertisement', PanelAdvertisementController::class)
                    ->withTrashed(['show', 'update']);
                /*
                |--------------------------------------------------------------------------
                | Gallery Routes
                |--------------------------------------------------------------------------
                */
                Route::prefix('gallery')
                    ->name('gallery')
                    ->group(function (): void {
                        Route::get('{advertisement}', [PanelGalleryController::class, 'index'])->name('index');
                        Route::post('{advertisement}/store', [PanelGalleryController::class, 'store'])->name('store');
                        Route::get('show/{gallery}', [PanelGalleryController::class, 'show'])->name('show')
                            ->withTrashed();
                        Route::put('{gallery}', [PanelGalleryController::class, 'update'])->name('update')
                            ->withTrashed();
                        Route::delete('{gallery}', [PanelGalleryController::class, 'destroy'])->name('destroy');
                    });
                /*
                |--------------------------------------------------------------------------
                | Note Routes
                |--------------------------------------------------------------------------
                */
                Route::prefix('notes')
                    ->name('notes.')
                    ->controller(AdvertisementNoteController::class)
                    ->group(function (): void {
                        Route::post('{advertisement}/store', 'store')->name('store');
                        Route::get('/', 'index')->name('index');
                        Route::get('{advertisement}/show', 'show')->name('show')
                            ->withTrashed();
                        Route::delete('{advertisement}/destroy', 'destroy')->name('destroy');
                    });
            });
        /*
        |--------------------------------------------------------------------------
        | User Favorite Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('favorites')
            ->name('favorites.')
            ->controller(FavoriteAdvertisementController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::post('{advertisement}', 'store')->name('store');
                Route::delete('{advertisement}', 'destroy')->name('destroy');
            });
        /*
        |--------------------------------------------------------------------------
        | User History Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('history')
            ->name('history.')
            ->controller(HistoryAdvertisementController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::post('{advertisement}', 'store')->name('store');
            });
    });
