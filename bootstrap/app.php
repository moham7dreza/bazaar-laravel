<?php

use App\Http\Responses\ApiJsonResponse;
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
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->reportable(function (Throwable $e): void {
            FilamentExceptions::report($e);
        });

        $exceptions->renderable(function (Throwable $e) {

            // Authorization
            if ($e instanceof AuthorizationException) {
                return ApiJsonResponse::error('AuthorizationException', ['log' => $e->getMessage()], Response::HTTP_FORBIDDEN);
            }

            // Access Denied
            if ($e instanceof AccessDeniedHttpException) {
                return ApiJsonResponse::error('AccessDeniedHttpException', ['log' => $e->getMessage()], Response::HTTP_FORBIDDEN);
            }

            // Model Not Found
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException) {
                $model = str($previous->getModel())->afterLast('\\');

                return ApiJsonResponse::error("$model Not Found.", ['log' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            }

            // Database
            if ($e instanceof QueryException) {
                return ApiJsonResponse::error('QueryException', ['log' => $e->getMessage()]);
            }

            // for other exceptions
            if (! $e instanceof ValidationException) {
                return ApiJsonResponse::error('Server Error', ['log' => $e->getMessage()]);
            }
        });

    })
    ->create();
