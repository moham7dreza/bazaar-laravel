<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Enums\Queue;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Modules\Monitoring\Collectors\Horizon as CustomHorizonCollectors;
use Override;
use Spatie\Prometheus\Collectors\Horizon as HorizonCollectors;
use Spatie\Prometheus\Collectors\Queue as QueueCollector;
use Spatie\Prometheus\Facades\Prometheus;

final class PrometheusServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerGauges();

        $this->registerHorizonCollectors();

        $this->registerCustomHorizonCollectors();

        $this->registerQueueCollectors(Queue::values());
    }

    public function registerGauges(): void
    {
        Prometheus::addGauge('User count')
            ->label('status')
            ->helpText('This is the number of users in our app')
            ->namespace('app')
            ->value(fn () => [
                [User::query()->where('is_active', 1)->count(), ['active']],
                [User::query()->where('is_active', 0)->count(), ['inactive']],
            ]);
    }

    public function registerHorizonCollectors(): self
    {
        Prometheus::registerCollectorClasses([
            HorizonCollectors\CurrentMasterSupervisorCollector::class,
            HorizonCollectors\CurrentProcessesPerQueueCollector::class,
            HorizonCollectors\CurrentWorkloadCollector::class,
            HorizonCollectors\FailedJobsPerHourCollector::class,
            HorizonCollectors\HorizonStatusCollector::class,
            HorizonCollectors\JobsPerMinuteCollector::class,
            HorizonCollectors\RecentJobsCollector::class,
        ]);

        return $this;
    }

    public function registerCustomHorizonCollectors(): self
    {
        Prometheus::registerCollectorClasses([
            CustomHorizonCollectors\CustomCurrentQueueWorkloadCollector::class,
            CustomHorizonCollectors\CustomCurrentProcessesPerQueueCollector::class,
            CustomHorizonCollectors\CustomCurrentQueueWaitCollector::class,
        ]);

        return $this;
    }

    public function registerQueueCollectors(array $queues = [], ?string $connection = null): self
    {
        Prometheus::registerCollectorClasses([
            QueueCollector\QueueSizeCollector::class,
            QueueCollector\QueuePendingJobsCollector::class,
            QueueCollector\QueueDelayedJobsCollector::class,
            QueueCollector\QueueReservedJobsCollector::class,
            QueueCollector\QueueOldestPendingJobCollector::class,
        ], compact('connection', 'queues'));

        return $this;
    }
}
