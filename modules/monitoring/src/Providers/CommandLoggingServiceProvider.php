<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use Exception;
use Illuminate\Console\Events;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Monitoring\Enums\CommandLoggingStatus;
use Modules\Monitoring\Models\CommandPerformanceLog;

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
    private CommandPerformanceLog $log;

    public function boot(): void
    {
        if (
            $this->app->runningUnitTests()
            || config('performance-log.command_log_disabled')
        ) {
            return;
        }

        $this->listenToCommandStartingEventAndLogIt();

        $this->listenToCommandFinishedEventAndUpdateLog();
    }

    private static function isExcluded(?string $command): bool
    {
        return in_array($command, self::EXCLUDED_COMMANDS, true);
    }

    private function listenToCommandStartingEventAndLogIt(): void
    {
        Event::listen(Events\CommandStarting::class, function (Events\CommandStarting $event) {
            try {
                if (self::isExcluded($event->command)) {
                    return;
                }

                $this->startTime = microtime(true);
                $this->startMemory = memory_get_usage();
                $this->queryCount = 0;
                $this->totalQueryTime = 0;

                DB::listen(function (QueryExecuted $query) {
                    $this->queryCount++;
                    $this->totalQueryTime += $query->time;
                });

                $data = [
                    'command' => $event->command ?? 'unknown',
                    'status' => CommandLoggingStatus::Started,
                    'inputs' => [
                        'arguments' => $event->input->getArguments(),
                        'options' => $event->input->getOptions(),
                    ],
                    'runtime' => 0,
                    'memory_usage' => 0,
                    'query_count' => 0,
                    'query_time' => 0,
                ];

                $this->log = CommandPerformanceLog::query()->create($data);
            } catch (Exception $e) {
                report($e);
            }
        });
    }

    private function listenToCommandFinishedEventAndUpdateLog(): void
    {
        Event::listen(Events\CommandFinished::class, function (Events\CommandFinished $event) {
            try {
                if (self::isExcluded($event->command)) {
                    return;
                }

                $endTime = microtime(true);
                $endMemory = memory_get_usage();

                $duration = $endTime - $this->startTime;
                $memoryUsage = $endMemory - $this->startMemory;

                $this->log->update([
                    'status' => CommandLoggingStatus::Completed,
                    'runtime' => round($duration * 1000), // milliseconds
                    'memory_usage' => $memoryUsage,
                    'query_count' => $this->queryCount,
                    'query_time' => round($this->totalQueryTime), // milliseconds
                ]);
            } catch (Exception $e) {
                report($e);
            }
        });
    }
}
