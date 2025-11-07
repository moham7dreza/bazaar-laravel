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
use Modules\Auth\Http\Controllers\RegisteredUserController;
use Modules\Auth\Http\Controllers\RegisteredUserWithOTPController;
use Modules\Auth\Http\Controllers\VerifyUserWithOTPController;
use Modules\Content\Http\Controllers\Admin\MenuController;
use Modules\Content\Http\Controllers\Admin\PageController;
use Modules\Content\Http\Controllers\App\MenuController as HomeMenuController;
use Modules\Content\Http\Controllers\App\PageController as HomePageController;

/**
 * Note: Route names are hard coded and repeated in every route
 *      for better finding routes with simple search
 *      and better categorize route sections and find them.
 */
Route::get('user', static fn (Request $request) => $request->user())
    ->name('api.user.info')
    ->middleware(['auth:sanctum', EnsureMobileIsVerified::class]);
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')
    ->middleware([
        'guest',
        'throttle:10,1',
    ])
    ->group(function (): void {
        Route::post('register', RegisteredUserController::class)
            ->name('api.auth.register');
        Route::post('send-otp', RegisteredUserWithOTPController::class)
            ->name('api.auth.send-otp')
            ->middleware(MetricsLoggerMiddleware::class);
        Route::post('verify-otp', VerifyUserWithOTPController::class)
            ->name('api.auth.verify-otp');
    });
/*
|--------------------------------------------------------------------------
| Primary Routes
|--------------------------------------------------------------------------
*/
Route::get('categories', [HomeCategoryController::class, 'index'])
    ->name('api.categories.index');
Route::get('menus', [HomeMenuController::class, 'index'])
    ->name('api.menus.index');
Route::get('pages', [HomePageController::class, 'index'])
    ->name('api.pages.index');
Route::get('states', [HomeStateController::class, 'index'])
    ->name('api.states.index');
Route::get('cities', [CityController::class, 'index'])
    ->name('api.cities.index');
/*
|--------------------------------------------------------------------------
| Advertisement Routes
|--------------------------------------------------------------------------
*/
Route::prefix('advertisements')
    ->middleware('cache-response:120')
    ->group(function (): void {
        Route::controller(HomeAdvertisementController::class)
            ->group(function (): void {
                Route::get('/', 'index')
                    ->name('api.advertisements.index');
                // test route for query builder
                // /api/advertisements/query-builder?filter[title]=Prof&filter[price]=200&sort=-price
                Route::get('query-builder', 'queryBuilder');
                Route::get('{advertisement}', 'show')
                    ->name('api.advertisements.show')
                    ->withTrashed();
            });
        Route::controller(HomeAdvertisementGalleryController::class)
            ->group(function (): void {
                Route::get('{advertisement}/gallery', 'index')
                    ->name('api.advertisements.gallery.index');
            });
        Route::prefix('category')
            ->group(function (): void {
                Route::get('{category}/attributes', HomeCategoryAttributeController::class)
                    ->name('api.advertisements.category.attributes.index');
                Route::get('{categoryAttribute}/values', HomeCategoryValueController::class)
                    ->name('api.advertisements.category.values.index');
            });
    });

/*
|--------------------------------------------------------------------------
| Image Routes
|--------------------------------------------------------------------------
*/
Route::prefix('images')
    ->controller(ImageController::class)
    ->group(function (): void {
        Route::post('store', 'store')
            ->name('api.images.store');
        Route::put('update', 'update')
            ->name('api.images.destroy');
    });
/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware([/* 'auth', 'admin' */])
    ->group(function (): void {
        /*
        |--------------------------------------------------------------------------
        | Advertisements Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('advertisements')
            ->group(function (): void {
                Route::apiResource('category', CategoryController::class)
                    ->names([
                        'index'   => 'api.admin.advertisements.category.index',
                        'store'   => 'api.admin.advertisements.category.store',
                        'show'    => 'api.admin.advertisements.category.show',
                        'update'  => 'api.admin.advertisements.category.update',
                        'destroy' => 'api.admin.advertisements.category.destroy',
                    ]);
                Route::apiResource('{advertisement}/gallery', GalleryController::class)
                    ->names([
                        'index'   => 'api.admin.advertisements.gallery.index',
                        'store'   => 'api.admin.advertisements.gallery.store',
                        'show'    => 'api.admin.advertisements.gallery.show',
                        'update'  => 'api.admin.advertisements.gallery.update',
                        'destroy' => 'api.admin.advertisements.gallery.destroy',
                    ]);
                Route::apiResource('state', StateController::class)
                    ->names([
                        'index'   => 'api.admin.advertisements.state.index',
                        'store'   => 'api.admin.advertisements.state.store',
                        'show'    => 'api.admin.advertisements.state.show',
                        'update'  => 'api.admin.advertisements.state.update',
                        'destroy' => 'api.admin.advertisements.state.destroy',
                    ]);
                Route::apiResource('category-attribute', CategoryAttributeController::class)
                    ->names([
                        'index'   => 'api.admin.advertisements.category-attributes.index',
                        'store'   => 'api.admin.advertisements.category-attributes.store',
                        'show'    => 'api.admin.advertisements.category-attributes.show',
                        'update'  => 'api.admin.advertisements.category-attributes.update',
                        'destroy' => 'api.admin.advertisements.category-attributes.destroy',
                    ]);
                Route::apiResource('category-value', CategoryValueController::class)
                    ->names([
                        'index'   => 'api.admin.advertisements.category-value.index',
                        'store'   => 'api.admin.advertisements.category-value.store',
                        'show'    => 'api.admin.advertisements.category-value.show',
                        'update'  => 'api.admin.advertisements.category-value.update',
                        'destroy' => 'api.admin.advertisements.category-value.destroy',
                    ]);
                Route::apiResource('advertisement', AdvertisementController::class)
                    ->names([
                        'index'   => 'api.admin.advertisements.advertisement.index',
                        'store'   => 'api.admin.advertisements.advertisement.store',
                        'show'    => 'api.admin.advertisements.advertisement.show',
                        'update'  => 'api.admin.advertisements.advertisement.update',
                        'destroy' => 'api.admin.advertisements.advertisement.destroy',
                    ])
                    ->withTrashed();
            });
        /*
        |--------------------------------------------------------------------------
        | Content Section Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('content')
            ->group(function (): void {
                Route::apiResource('menu', MenuController::class)
                    ->names([
                        'index'   => 'api.admin.content.menu.index',
                        'store'   => 'api.admin.content.menu.store',
                        'show'    => 'api.admin.content.menu.show',
                        'update'  => 'api.admin.content.menu.update',
                        'destroy' => 'api.admin.content.menu.destroy',
                    ]);
                Route::apiResource('page', PageController::class)
                    ->names([
                        'index'   => 'api.admin.content.page.index',
                        'store'   => 'api.admin.content.page.store',
                        'show'    => 'api.admin.content.page.show',
                        'update'  => 'api.admin.content.page.update',
                        'destroy' => 'api.admin.content.page.destroy',
                    ]);
            });
        /*
        |--------------------------------------------------------------------------
        | Users Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('users')
            ->group(function (): void {
                Route::apiResource('user', UserController::class)
                    ->names([
                        'index'   => 'api.admin.users.user.index',
                        'store'   => 'api.admin.users.user.store',
                        'show'    => 'api.admin.users.user.show',
                        'update'  => 'api.admin.users.user.update',
                        'destroy' => 'api.admin.users.user.destroy',
                    ]);
            });
    });

/*
|--------------------------------------------------------------------------
| User Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('panel')
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
            ->group(function (): void {
                Route::apiResource('advertisement', PanelAdvertisementController::class)
                    ->names([
                        'index'   => 'api.panel.advertisements.advertisement.index',
                        'store'   => 'api.panel.advertisements.advertisement.store',
                        'show'    => 'api.panel.advertisements.advertisement.show',
                        'update'  => 'api.panel.advertisements.advertisement.update',
                        'destroy' => 'api.panel.advertisements.advertisement.destroy',
                    ])
                    ->withTrashed(['show', 'update']);
                /*
                |--------------------------------------------------------------------------
                | Gallery Routes
                |--------------------------------------------------------------------------
                */
                Route::prefix('gallery')
                    ->controller(PanelGalleryController::class)
                    ->group(function (): void {
                        Route::get('{advertisement}', 'index')
                            ->name('api.panel.advertisements.gallery.index');
                        Route::post('{advertisement}/store', 'store')
                            ->name('api.panel.advertisements.gallery.store');
                        Route::get('show/{gallery}', 'show')
                            ->name('api.panel.advertisements.gallery.show')
                            ->withTrashed();
                        Route::put('{gallery}', 'update')
                            ->name('api.panel.advertisements.gallery.update')
                            ->withTrashed();
                        Route::delete('{gallery}', 'destroy')
                            ->name('api.panel.advertisements.gallery.destroy');
                    });
                /*
                |--------------------------------------------------------------------------
                | Note Routes
                |--------------------------------------------------------------------------
                */
                Route::prefix('notes')
                    ->controller(AdvertisementNoteController::class)
                    ->group(function (): void {
                        Route::post('{advertisement}/store', 'store')
                            ->name('api.panel.advertisements.note.store');
                        Route::get('/', 'index')
                            ->name('api.panel.advertisements.note.index');
                        Route::get('{advertisement}/show', 'show')
                            ->name('api.panel.advertisements.note.show')
                            ->withTrashed();
                        Route::delete('{advertisement}/destroy', 'destroy')
                            ->name('api.panel.advertisements.note.destroy');
                    });
            });
        Route::prefix('users')
            ->group(function (): void {
                Route::prefix('advertisements')
                    ->group(function (): void {
                        /*
                        |--------------------------------------------------------------------------
                        | User Favorite Routes
                        |--------------------------------------------------------------------------
                        */
                        Route::prefix('favorite')
                            ->controller(FavoriteAdvertisementController::class)
                            ->group(function (): void {
                                Route::get('/', 'index')
                                    ->name('api.panel.users.advertisements.favorite.index');
                                Route::post('{advertisement}', 'store')
                                    ->name('api.panel.users.advertisements.favorite.store');
                                Route::delete('{advertisement}', 'destroy')
                                    ->name('api.panel.users.advertisements.favorite.destroy');
                            });
                        /*
                        |--------------------------------------------------------------------------
                        | User History Routes
                        |--------------------------------------------------------------------------
                        */
                        Route::prefix('history')
                            ->controller(HistoryAdvertisementController::class)
                            ->group(function (): void {
                                Route::get('/', 'index')
                                    ->name('api.panel.users.advertisements.history.index');
                                Route::post('{advertisement}', 'store')
                                    ->name('api.panel.users.advertisements.history.store');
                            });
                    });
            });
    });

/*
|--------------------------------------------------------------------------
| Environment specific Routes
|--------------------------------------------------------------------------
*/
when(isEnvStaging(), function (): void {
});

when(isEnvLocal(), static function (): void {
    Route::post('idempotency', static fn () => logger('idempotency passed'))
        ->middleware(Infinitypaul\Idempotency\Middleware\EnsureIdempotency::class)
        ->name('idempotency');

    Route::get('lock-test', static fn () => print 1)->block(
        lockSeconds: 5,
        waitSeconds: 5,
    );

    Route::get('test-mailables', static fn () => new App\Mail\UserLandMail(
        subject: 'welcome',
        from: [
            [
                'address' => config()->string('mail.from.address'),
                'name'    => config()->string('mail.from.name'),
            ],
        ],
        details: [
            'subject' => 'test',
            'body'    => 'test',
        ],
    ));
});

when(isEnvLocalOrTesting(), static function (): void {
    Route::get('today/{date}', static fn ($date) => $date)
        ->name('api.today.date');
});
