<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\BackupsCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\RedisMemoryUsageCheck;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

final class HealthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
//        $this->runHealthChecks();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('viewHealth', static fn (?User $user) => ! isEnvLocalOrTesting() ? $user?->isAdmin() : true);
    }

    private function runHealthChecks(): void
    {
        if ($this->app->runningUnitTests())
        {
            return;
        }

        Health::checks([
            DatabaseCheck::new(),
            CacheCheck::new(),
            QueueCheck::new(),
            RedisCheck::new(),
            BackupsCheck::new(),
            EnvironmentCheck::new()->expectEnvironment(getenv('APP_ENV')),
            DatabaseTableSizeCheck::new()
                ->table('advertisements', maxSizeInMb: 1_000),
            DatabaseSizeCheck::new()
                ->failWhenSizeAboveGb(errorThresholdGb: 0.1),
            DatabaseConnectionCountCheck::new()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),
            DebugModeCheck::new(),
            OptimizedAppCheck::new(),
            PingCheck::new()->url(getenv('APP_URL'))->timeout(2)->retryTimes(3)->label('App'),
            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            HorizonCheck::new(),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
            ScheduleCheck::new()->heartbeatMaxAgeInMinutes(2),
            SecurityAdvisoriesCheck::new(),
            RedisMemoryUsageCheck::new()
                ->warnWhenAboveMb(900)
                ->failWhenAboveMb(1000),
        ]);
    }
}
