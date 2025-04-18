<?php

use App\Http\Responses\ApiJsonResponse;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        //        then: function () {
        //            Route::middleware('api')
        //                ->prefix('api')
        //                ->name('api.')
        //                ->group(base_path('routes/api.php'));
        //        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->append([
            \App\Http\Middleware\UserCheckSuspendedMiddleware::class,
            \App\Http\Middleware\EnableDebugForDeveloper::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        ]);

        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'mobileVerified' => \App\Http\Middleware\EnsureMobileIsVerified::class,
            'admin' => \App\Http\Middleware\CheckAdminMiddleware::class,
            'dev' => \App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
            'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->reportable(function (Throwable $e) {
            FilamentExceptions::report($e);
        });

        $exceptions->renderable(function (Throwable $e) {

            $previous = $e->getPrevious();

            if ($previous instanceof ModelNotFoundException) {
                $fullModel = $previous->getModel();

                $model = str($fullModel)->afterLast('\\');

                return ApiJsonResponse::error("$model Not Found.", ['log' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            }
        });

    })
    ->create();
