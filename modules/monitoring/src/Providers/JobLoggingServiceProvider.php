<?php

declare(strict_types=1);

namespace Modules\Monitoring\Providers;

use App\Events\PackageSent;
use App\Jobs\Contracts\ShouldNotifyOnFailures;
use App\Notifications\FailedJobNotification;
use Exception;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Monitoring\Jobs\MongoLogJob;
use Modules\Monitoring\Models\JobPerformanceLog;

final class JobLoggingServiceProvider extends ServiceProvider
{
    private const array EXCLUDED_JOBS = [
        MongoLogJob::class,
        PackageSent::class,
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
        if ($this->shouldSkipLogging())
        {
            return;
        }
        $this->handleJobProcessing();
        $this->handleJobProcessed();
        $this->handleJobQueued();
        $this->handleJobFailed();
    }

    private static function isExcluded(?string $job): bool
    {
        return in_array($job, self::EXCLUDED_JOBS, true);
    }

    private function shouldSkipLogging(): bool
    {
        if ($this->app->runningUnitTests())
        {
            return true;
        }

        return config()->boolean('performance-log.job_log_disabled');
        //            || !Lottery::odds(config('performance-log.job_log_sampling_rate'))->choose()
    }

    private function handleJobProcessing(): void
    {
        Event::listen(function (JobProcessing $event): void {
            try
            {
                if (self::isExcluded($event->job->resolveName()))
                {
                    return;
                }
                $this->startTime      = microtime(true);
                $this->startMemory    = memory_get_usage();
                $this->queryCount     = 0;
                $this->totalQueryTime = 0;

                DB::listen(function (QueryExecuted $query): void {
                    $this->queryCount++;
                    $this->totalQueryTime += $query->time;
                });
            } catch (Exception $e)
            {
                report($e);
            }
        });
    }

    private function handleJobProcessed(): void
    {
        Event::listen(function (JobProcessed $event): void {
            try
            {
                if (self::isExcluded($event->job->resolveName()))
                {
                    return;
                }

                $endTime   = microtime(true);
                $endMemory = memory_get_usage();

                $duration    = $endTime   - $this->startTime;
                $memoryUsage = $endMemory - $this->startMemory;

                $data = [
                    'job'          => $event->job->resolveName(),
                    'connection'   => $event->job->getConnectionName(),
                    'queue'        => $event->job->getQueue(),
                    'attempts'     => $event->job->attempts(),
                    'started_at'   => Date::createFromTimestamp($this->startTime)->toDateTimeString(),
                    'runtime'      => round($duration * 1000), // milliseconds
                    'memory_usage' => $memoryUsage,
                    'query_count'  => $this->queryCount,
                    'query_time'   => round($this->totalQueryTime), // milliseconds
                ];

                JobPerformanceLog::query()->create($data);
            } catch (Exception $e)
            {
                report($e);
            }
        });
    }

    private function handleJobQueued(): void
    {
        Event::listen(static function (JobQueued $event): void {
            $job = $event->job::class;
            context()->push('queued_job_history', "Job queued: {$job}");
        });
    }

    private function handleJobFailed(): void
    {
        Event::listen(static function (JobFailed $event): void {
            $job = $event->job::class;
            context()->push('failed_job_history', "Job failed: {$job}");

            $payload = [
                'exception' => $event->exception->getMessage(),
                'job-class' => $event->job->getName(),
                'job-body'  => $event->job->getRawBody(),
                'job-trace' => $event->exception->getTraceAsString(),
            ];

            mongo_info('failed-job', $payload);

            if ($event->job instanceof ShouldNotifyOnFailures)
            {

                admin()?->notify(new FailedJobNotification($payload));
            }
        });
    }
}
