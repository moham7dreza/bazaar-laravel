<?php

declare(strict_types=1);

namespace Modules\Monitoring\Collectors\Horizon;

use Illuminate\Support\Arr;
use Modules\Monitoring\Repositories\RedisQueueWorkloadRepository;
use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

final class CustomCurrentProcessesPerQueueCollector implements Collector
{
    public function register(): void
    {
        Prometheus::addGauge('Horizon Current Processes')
            ->name('horizon_queue_current_processes')
            ->helpText('Current processes of all queues')
            ->label('queue')
            ->value(fn () => collect(app(RedisQueueWorkloadRepository::class)->get())
                ->sortBy('name')
                ->values()
                ->map(fn (array $workload) => [Arr::get($workload, 'processes'), [Arr::get($workload, 'name')]])
                ->all());
    }
}
