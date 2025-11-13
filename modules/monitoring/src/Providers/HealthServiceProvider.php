<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Override;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

final class HealthServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::define('viewHealth', static fn (?User $user) => ! isEnvLocalOrTesting() ? $user?->isAdmin() : true);

        $this->runHealthChecks();
    }

    private function runHealthChecks(): void
    {
        if ($this->app->runningUnitTests())
        {
            return;
        }

        Health::checks([
            Checks\DatabaseCheck::new(),

            Checks\CacheCheck::new(),

            Checks\QueueCheck::new(),

            Checks\RedisCheck::new(),

            Checks\BackupsCheck::new(),

            Checks\EnvironmentCheck::new()
                ->expectEnvironment(config()->string('app.env')),

            Checks\DatabaseTableSizeCheck::new()
                ->table('advertisements', maxSizeInMb: 1_000),

            Checks\DatabaseSizeCheck::new()
                ->failWhenSizeAboveGb(errorThresholdGb: 0.1),

            Checks\DatabaseConnectionCountCheck::new()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),

            Checks\DebugModeCheck::new(),

            Checks\OptimizedAppCheck::new(),

            Checks\PingCheck::new()
                ->url(config()->string('app.url'))
                ->timeout(2)
                ->retryTimes(3)
                ->label('App'),

            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),

            Checks\HorizonCheck::new(),

            Checks\UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),

            Checks\ScheduleCheck::new()
                ->heartbeatMaxAgeInMinutes(2),

            SecurityAdvisoriesCheck::new(),

            Checks\RedisMemoryUsageCheck::new()
                ->warnWhenAboveMb(900)
                ->failWhenAboveMb(1000),
        ]);
    }
}
