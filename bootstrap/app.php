<?php

use App\Http\Responses\ApiNewJsonResponse;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    //        then: function () {
    //            Route::middleware('api')
    //                ->prefix('api/v1')
    //                ->name('api.v1.')
    //                ->group(base_path('routes/api_v1.php'));
    //        },
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->append([
            \App\Http\Middleware\UserCheckSuspendedMiddleware::class,
            \App\Http\Middleware\EnableDebugForDeveloper::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        ]);

        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \App\Http\Middleware\RequireJsonMiddleware::class,
            \App\Http\Middleware\ApiRequestLoggerMiddleware::class,
        ]);

        $middleware->alias([
            'verified'       => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'mobileVerified' => \App\Http\Middleware\EnsureMobileIsVerified::class,
            'admin'          => \App\Http\Middleware\CheckAdminMiddleware::class,
            'dev'            => \App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
            'abilities'      => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability'        => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        /**
         * to avoid redirect user to login when user:
         * 1. did not set `Accept: application/json` header
         * 2. user was unauthenticated.
         * solution: enforce json response
         */
        $exceptions->shouldRenderJsonWhen(fn () => request()->is('api/*') || request()->expectsJson());

        $exceptions->reportable(function (Throwable $e): void {
            FilamentExceptions::report($e);
        });

        $exceptions->renderable(function (Throwable $e) {

            // Authorization
            if ($e instanceof AuthorizationException) {
                return ApiNewJsonResponse::error(Response::HTTP_FORBIDDEN, 'AuthorizationException');
            }

            // Access Denied
            if ($e instanceof AccessDeniedHttpException) {
                return ApiNewJsonResponse::error(Response::HTTP_FORBIDDEN, 'AccessDeniedHttpException');
            }

            // Model Not Found
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException) {
                $model = str($previous->getModel())->afterLast('\\');

                $message = isEnvProduction() ? 'Record Not Found.' : "$model Not Found.";

                return ApiNewJsonResponse::error(Response::HTTP_NOT_FOUND, $message);
            }

            // Database
            if ($e instanceof QueryException) {

                return ApiNewJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'QueryException');
            }

            // for other exceptions
            /*
            if (! $e instanceof ValidationException) {
                return ApiNewJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Server Error');
            }
            */
        });

    })
    ->create();
