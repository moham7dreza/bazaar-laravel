<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Modules\Monitoring\Collectors\Horizon\CustomCurrentProcessesPerQueueCollector;
use Modules\Monitoring\Collectors\Horizon\CustomCurrentQueueWaitCollector;
use Modules\Monitoring\Collectors\Horizon\CustomCurrentQueueWorkloadCollector;
use Modules\Monitoring\Repositories\RedisQueueWorkloadRepository;
use Spatie\Prometheus\Collectors\Horizon\CurrentMasterSupervisorCollector;
use Spatie\Prometheus\Collectors\Horizon\CurrentProcessesPerQueueCollector;
use Spatie\Prometheus\Collectors\Horizon\CurrentWorkloadCollector;
use Spatie\Prometheus\Collectors\Horizon\FailedJobsPerHourCollector;
use Spatie\Prometheus\Collectors\Horizon\HorizonStatusCollector;
use Spatie\Prometheus\Collectors\Horizon\JobsPerMinuteCollector;
use Spatie\Prometheus\Collectors\Horizon\RecentJobsCollector;
use Spatie\Prometheus\Facades\Prometheus;

final class PrometheusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerGauges();
        $this->registerHorizonCollectors();
        $this->registerCustomHorizonCollectors();
    }

    public function boot(): void
    {
//        $metrics = app(RedisQueueWorkloadRepository::class)->get();
    }

    private function registerGauges(): void
    {
        Prometheus::addGauge('User count')
            ->label('status')
            ->helpText('This is the number of users in our app')
            ->namespace('app')
            ->value(fn () => [
                [User::where('is_active', 1)->count(), ['active']],
                [User::where('is_active', 0)->count(), ['inactive']],
            ]);
    }

    private function registerHorizonCollectors(): void
    {
        Prometheus::registerCollectorClasses([
            CurrentMasterSupervisorCollector::class,
            CurrentProcessesPerQueueCollector::class,
            CurrentWorkloadCollector::class,
            FailedJobsPerHourCollector::class,
            HorizonStatusCollector::class,
            JobsPerMinuteCollector::class,
            RecentJobsCollector::class,
        ]);
    }

    private function registerCustomHorizonCollectors(): void
    {
        Prometheus::registerCollectorClasses([
            CustomCurrentQueueWorkloadCollector::class,
            CustomCurrentProcessesPerQueueCollector::class,
            CustomCurrentQueueWaitCollector::class,
        ]);
    }
}
