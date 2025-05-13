<?php

declare(strict_types=1);

namespace Modules\Monitoring\Collectors\Horizon;

use Modules\Monitoring\Repositories\RedisQueueWorkloadRepository;
use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

final class CustomCurrentQueueWorkloadCollector implements Collector
{
    public function register(): void
    {
        Prometheus::addGauge('Current workload')
            ->name('horizon_queue_current_workload')
            ->label('queue')
            ->helpText('Current workload of all queues')
            ->value(fn () => collect(app(RedisQueueWorkloadRepository::class)->get())
                ->sortBy('name')
                ->values()
                ->map(fn (array $workload) => [$workload['length'], [$workload['name']]])
                ->toArray());
    }
}
