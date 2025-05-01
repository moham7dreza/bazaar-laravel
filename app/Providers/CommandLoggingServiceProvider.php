<?php

namespace App\Providers;

use App\Models\Monitor\CommandPerformanceLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Events;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

final class CommandLoggingServiceProvider extends ServiceProvider
{
    private const array EXCLUDED_COMMANDS = [
        'horizon:work',
        'health:custom-check',
        'health:schedule-check-heartbeat',
        'health:queue-check-heartbeat',
        'horizon:snapshot',
        'horizon:status',
        'schedule:run',
        'schedule:work',
        'schedule:finish',
        'queue:work',
        'queue:listen',
        'inspire',
        'health:check',
    ];

    private float $startTime;

    private int $startMemory;

    private int $queryCount;

    private float $totalQueryTime;

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (
            $this->app->runningUnitTests()
            || config('performance-log.command_log_disabled')
        ) {
            return;
        }

        Event::listen(function (Events\CommandStarting $event): void {
            try {
                if (self::isExcluded($event->command)) {
                    return;
                }

                $this->startTime = microtime(true);
                $this->startMemory = memory_get_usage();
                $this->queryCount = 0;
                $this->totalQueryTime = 0;

                DB::listen(function (QueryExecuted $query): void {
                    $this->queryCount++;
                    $this->totalQueryTime += $query->time;
                });
            } catch (Exception $e) {
                report($e);
            }
        });

        Event::listen(function (Events\CommandFinished $event): void {
            try {
                if (self::isExcluded($event->command)) {
                    return;
                }

                $endTime = microtime(true);
                $endMemory = memory_get_usage();

                $duration = $endTime - $this->startTime;
                $memoryUsage = $endMemory - $this->startMemory;

                $data = [
                    'command' => $event->command ?? 'unknown',
                    'started_at' => Carbon::createFromTimestamp($this->startTime)->toDateTimeString(),
                    'runtime' => round($duration * 1000), // milliseconds
                    'memory_usage' => $memoryUsage,
                    'query_count' => $this->queryCount,
                    'query_time' => round($this->totalQueryTime), // milliseconds
                ];

                CommandPerformanceLog::query()->create($data);
            } catch (Exception $e) {
                report($e);
            }
        });
    }

    private static function isExcluded(?string $command): bool
    {
        return in_array($command, self::EXCLUDED_COMMANDS, true);
    }
}
