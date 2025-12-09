<?php

declare(strict_types=1);

use App\Enums\UserPermission as P;
use App\Exceptions\HasCustomizedThrottling;
use App\Http\Middleware\EnsureMobileIsVerified;
use App\Http\Responses\ApiJsonResponse;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Cog\Laravel\Ban\Console\Commands\DeleteExpiredBans;
use DirectoryTree\Metrics\Commands\CommitMetrics;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
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
        // TODO setup version 1
        //        then: function () {
        //            Route::middleware('api')
        //                ->prefix('api/v1')
        //                ->name('api.v1.')
        //                ->group(base_path('routes/api_v1.php'));
        //        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        $middleware->throttleApi('api-custom', true);

        $middleware->trustHosts();

        $middleware->append([
            App\Http\Middleware\UserCheckSuspendedMiddleware::class,
            App\Http\Middleware\EnableDebugForDeveloper::class,
            App\Http\Middleware\HttpsRedirectMiddleware::class,
            App\Http\Middleware\UserPermissionsMiddleware::class,
        ]);

        $middleware->api(prepend: [
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            App\Http\Middleware\RequireJsonMiddleware::class,
            App\Http\Middleware\ApiRequestLoggerMiddleware::class,
            App\Http\Middleware\SetClientDomainMiddleware::class,
            App\Http\Middleware\SetClientLocaleMiddleware::class,
            App\Http\Middleware\SanitizeInputMiddleware::class,
            Cog\Laravel\Ban\Http\Middleware\ForbidBannedUser::class,
            Cog\Laravel\Ban\Http\Middleware\LogsOutBannedUser::class,
        ]);

        $middleware->alias([
            'verified'           => EnsureMobileIsVerified::class,
            'dev'                => App\Http\Middleware\OnlyAllowDevelopersMiddleware::class,
            // sanctum
            'abilities'          => Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability'            => Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
            // role permission
            'role'               => Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role-or-permission' => Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            // response cache
            'cache-response'     => Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'uncache-response'   => Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
            // ban
            'forbid-banned-user'   => Cog\Laravel\Ban\Http\Middleware\ForbidBannedUser::class,
            'logs-out-banned-user' => Cog\Laravel\Ban\Http\Middleware\LogsOutBannedUser::class,
        ]);

        $middleware->appendToGroup('administrator', [
            Authenticate::using('sanctum'),
            EnsureMobileIsVerified::class,
            EnsureEmailIsVerified::class,
            P::SeePanel->middleware(),
        ]);

        $middleware->appendToGroup('user', [
            Authenticate::using('sanctum'),
            EnsureMobileIsVerified::class,
            EnsureEmailIsVerified::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command(DeleteExpiredBans::class)->everyMinute();

        $schedule->command(CommitMetrics::class)->hourly();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * to avoid redirect user to login when user:
         * 1. did not set `Accept: application/json` header
         * 2. user was unauthenticated.
         * solution: enforce JSON response
         */
        $exceptions->shouldRenderJsonWhen(fn () => request()->is('api/*') || request()->expectsJson());

        $exceptions->reportable(function (Throwable $e): void {
            FilamentExceptions::report($e);
        });

        $exceptions->renderable(function (Throwable $e) {
            // TODO refactor
            if ($e instanceof AuthorizationException)
            {
                return ApiJsonResponse::error(Response::HTTP_FORBIDDEN, 'AuthorizationException');
            }

            if ($e instanceof AccessDeniedHttpException)
            {
                return ApiJsonResponse::error(Response::HTTP_FORBIDDEN, 'AccessDeniedHttpException');
            }

            if ($e instanceof AuthenticationException)
            {
                return ApiJsonResponse::error(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
            }

            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException)
            {
                $model = str($previous->getModel())->afterLast('\\');

                $message = app()->isProduction() ? 'Record Not Found.' : "{$model} Not Found.";

                return ApiJsonResponse::error(Response::HTTP_NOT_FOUND, $message);
            }

            if ($e instanceof QueryException)
            {
                if (1451 === $e->errorInfo[1])
                {
                    Log::error('MySQL FK violation', [
                        'exception'  => $e->getMessage(),
                        'trace'      => $e->getTraceAsString(),
                    ]);
                    report($e);

                    return ApiJsonResponse::error(Response::HTTP_UNPROCESSABLE_ENTITY, 'Unprocessable Entity');
                }

                return ApiJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Query Exception');
            }

            if ($e instanceof ValidationException)
            {
                return ApiJsonResponse::error(Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
            }

            if ($e instanceof RecordsNotFoundException)
            {
                return ApiJsonResponse::error(Response::HTTP_NOT_FOUND, 'Records not found.');
            }

            if ($e instanceof MultipleRecordsFoundException)
            {
                return ApiJsonResponse::error(Response::HTTP_UNPROCESSABLE_ENTITY, 'Multiple Records found, Only one record allowed.');
            }

            return ApiJsonResponse::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Unexpected error.');
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
