<?php

declare(strict_types=1);

use App\Enums\UserPermission as P;
use App\Exceptions\HasCustomizedThrottling;
use App\Http\Middleware\EnsureMobileIsVerified;
use App\Http\Responses\ApiJsonResponse;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Cog\Laravel\Ban\Console\Commands\DeleteExpiredBans;
use DirectoryTree\Metrics\Commands\CommitMetrics;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Date;

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
        $middleware->preventRequestsDuringMaintenance([
            '/register',
            '/register/*',
            '/terms',
            '/privacy',
        ]);

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
            'abilities'          => Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability'            => Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
            'role'               => Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role-or-permission' => Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'cache-response'     => Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'uncache-response'   => Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
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
        $exceptions->shouldRenderJsonWhen(fn () => request()->is('api/*') || request()->expectsJson());

        $exceptions->reportable(function (Throwable $e): void {
            FilamentExceptions::report($e);
        });

        $exceptions->renderable(function (Throwable $e) {
            $responseData = App\Exceptions\ExceptionMapper::map($e);

            if ($e instanceof QueryException && 1451 === $e->errorInfo[1])
            {
                Log::error('MySQL FK violation', [
                    'exception' => $e->getMessage(),
                    'trace'     => $e->getTraceAsString(),
                ]);
                report($e);
            }

            return ApiJsonResponse::error($responseData['status'], $responseData['message']);
        });

        $exceptions->map(function (ThrottleRequestsException $e) {
            $resetTime = Date::make($e->getHeaders()['X-RateLimit-Reset'])?->fromNow();

            return new ThrottleRequestsException(
                message: "Too Many Attempts. Please try again in {$resetTime}",
                headers: $e->getHeaders(),
            );
        });

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
