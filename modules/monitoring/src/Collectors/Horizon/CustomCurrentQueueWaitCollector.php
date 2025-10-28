<?php

declare(strict_types=1);

namespace Modules\Monitoring\Collectors\Horizon;

use Modules\Monitoring\Repositories\RedisQueueWorkloadRepository;
use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

final class CustomCurrentQueueWaitCollector implements Collector
{
    public function register(): void
    {
        Prometheus::addGauge('Current wait time of queue')
            ->name('horizon_queue_current_wait')
            ->label('queue')
            ->helpText('Current wait time of all queues')
            ->value(fn () => collect(app(RedisQueueWorkloadRepository::class)->get())
                ->sortBy('name')
                ->values()
                ->map(fn (array $workload) => [\Illuminate\Support\Arr::get($workload, 'wait'), [\Illuminate\Support\Arr::get($workload, 'name')]])
                ->all());
    }
}
