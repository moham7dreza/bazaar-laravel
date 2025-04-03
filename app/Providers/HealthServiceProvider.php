<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Health::checks([
            Checks\DatabaseCheck::new(),
            Checks\CacheCheck::new(),
            Checks\QueueCheck::new(),
            Checks\RedisCheck::new(),
            Checks\BackupsCheck::new(),
            Checks\EnvironmentCheck::new()->expectEnvironment(getenv('APP_ENV')),
            Checks\DatabaseTableSizeCheck::new()
                ->table('advertisements', maxSizeInMb: 1_000),
            Checks\DatabaseSizeCheck::new()
                ->failWhenSizeAboveGb(errorThresholdGb: 0.1),
            Checks\DatabaseConnectionCountCheck::new()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),
            Checks\DebugModeCheck::new(),
            Checks\OptimizedAppCheck::new(),
            Checks\PingCheck::new()->url(getenv('APP_URL'))->timeout(2)->retryTimes(3)->label('App'),
            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            Checks\HorizonCheck::new(),
            Checks\UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
            Checks\ScheduleCheck::new()->heartbeatMaxAgeInMinutes(2),
            SecurityAdvisoriesCheck::new(),
            Checks\RedisMemoryUsageCheck::new()
                ->warnWhenAboveMb(900)
                ->failWhenAboveMb(1000)
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('viewHealth', static function (?User $user) {
            return !isEnvLocalOrTesting() ? $user?->isAdmin() : true;
        });
    }
}
