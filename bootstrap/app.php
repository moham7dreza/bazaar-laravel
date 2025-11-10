<?php

declare(strict_types=1);

use App\Exceptions\HasCustomizedThrottling;
use App\Http\Responses\ApiJsonResponse;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
        //        then: function () {
        //            Route::middleware('api')
        //                ->prefix('api/v1')
        //                ->name('api.v1.')
        //                ->group(base_path('routes/api_v1.php'));
        //        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        $middleware->append([
            App\Http\Middleware\UserCheckSuspendedMiddleware::class,
            App\Http\Middleware\EnableDebugForDeveloper::class,
            Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            App\Http\Middleware\HttpsRedirectMiddleware::class,
            Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->api(prepend: [
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            //            \App\Http\Middleware\RequireJsonMiddleware::class,
            App\Http\Middleware\ApiRequestLoggerMiddleware::class,
            //            \App\Http\Middleware\OnlyAllowValidHostsMiddleware::class,
            App\Http\Middleware\SetClientDomainMiddleware::class,
            App\Http\Middleware\SetClientLocaleMiddleware::class,
            App\Http\Middleware\SanitizeInputMiddleware::class,
        ]);

        $middleware->alias([
            'verified'           => App\Http\Middleware\EnsureEmailIsVerified::class,
            'mobile-verified'    => App\Http\Middleware\EnsureMobileIsVerified::class,
            'admin'              => App\Http\Middleware\CheckAdminMiddleware::class,
            'dev'                => App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
            'abilities'          => Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability'            => Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
            'role'               => Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role-or-permission' => Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'cache-response'     => Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'uncache-response'   => Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
        ]);

        $middleware->appendToGroup('administrator', [
            'auth:sanctum', 'verified', 'mobile-verified', 'admin',
        ]);

    })
    ->withSchedule(function (Schedule $schedule): void {
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
            if ($e instanceof AuthorizationException)
            {
                return ApiJsonResponse::error(Response::HTTP_FORBIDDEN, 'AuthorizationException');
            }

            // Access Denied
            if ($e instanceof AccessDeniedHttpException)
            {
                return ApiJsonResponse::error(Response::HTTP_FORBIDDEN, 'AccessDeniedHttpException');
            }

            // Auth
            if ($e instanceof AuthenticationException)
            {
                //                return ApiJsonResponse::error(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
            }

            // Model Not Found
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException)
            {
                $model = str($previous->getModel())->afterLast('\\');

                $message = isEnvProduction() ? 'Record Not Found.' : "{$model} Not Found.";

                return ApiJsonResponse::error(Response::HTTP_NOT_FOUND, $message);
            }

            // Database
            if ($e instanceof QueryException)
            {
                return ApiJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'QueryException');
            }

            if ($e instanceof RuntimeException)
            {
                return ApiJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            }

            // for other exceptions
            if ( ! $e instanceof ValidationException)
            {
                //                return ApiJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Server Error');
            }
        });

        $exceptions->map(fn (ThrottleRequestsException $e) => new ThrottleRequestsException(
            message: 'Too Many Attempts. Please try again in ' . Date::make($e->getHeaders()['X-RateLimit-Reset'])?->fromNow(),
            headers: $e->getHeaders(),
        ));

        $exceptions->throttle(function (Throwable $e) {
            return match (true)
            {
                $e instanceof BroadcastException      => Limit::perMinute(300),
                $e instanceof HasCustomizedThrottling => $e->getLimit(),
                default                               => Limit::perSecond(1),
            };
        });
    })
    ->create();
