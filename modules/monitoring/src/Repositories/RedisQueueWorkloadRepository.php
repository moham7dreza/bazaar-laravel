<?php

declare(strict_types=1);

namespace Modules\Monitoring\Repositories;

use Illuminate\Contracts\Queue\Factory as QueueFactory;
use Illuminate\Support\Str;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Laravel\Horizon\Contracts\SupervisorRepository;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Laravel\Horizon\WaitTimeCalculator;

final class RedisQueueWorkloadRepository implements WorkloadRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  QueueFactory  $queue
     * @param  WaitTimeCalculator  $waitTime
     * @param  MasterSupervisorRepository  $masters
     * @param  SupervisorRepository  $supervisors
     * @return void
     */
    public function __construct(
        /**
         * The queue factory implementation.
         */
        public QueueFactory $queue,
        /**
         * The wait time calculator instance.
         */
        public WaitTimeCalculator $waitTime,
        /**
         * The master supervisor repository implementation.
         */
        private readonly MasterSupervisorRepository $masters,
        /**
         * The supervisor repository implementation.
         */
        private readonly SupervisorRepository $supervisors
    ) {
    }

    /**
     * Get the current workload of each queue, combined across all supervisors.
     *
     * @return array<int, array{"name": string, "length": int, "wait": int, "processes": int}>
     */
    public function get(): array
    {
        $processes = $this->processes();

        $combinedQueues = [];

        collect($this->waitTime->calculate())
            ->each(function ($waitTime, $queue) use ($processes, &$combinedQueues): void {
                [$connection, $queueName] = explode(':', $queue, 2);

                $totalProcesses = $processes[$queue] ?? 0;

                if (Str::contains($queue, ','))
                {
                    // Handle combined queues by splitting them
                    $splitQueues = collect(explode(',', $queueName))
                        ->mapWithKeys(fn ($singleQueue): array => [$singleQueue => $this->queue->connection($connection)->readyNow($singleQueue)]);

                    $splitQueues->each(function ($length, $singleQueue) use ($connection, $totalProcesses, &$combinedQueues): void {
                        if ( ! isset($combinedQueues[$singleQueue]))
                        {
                            $combinedQueues[$singleQueue] = [
                                'name'      => $singleQueue,
                                'length'    => 0,
                                'wait'      => 0,
                                'processes' => 0,
                            ];
                        }

                        $combinedQueues[$singleQueue]['length'] = max(
                            $combinedQueues[$singleQueue]['length'] ?? 0,
                            $length
                        );
                        // Use the maximum wait time for the queue
                        $combinedQueues[$singleQueue]['wait'] = min(
                            $combinedQueues[$singleQueue]['wait'],
                            $this->waitTime->calculateTimeToClear($connection, $singleQueue, $totalProcesses)
                        );
                        $combinedQueues[$singleQueue]['processes'] += $totalProcesses;
                    });
                } else
                {
                    // Handle single queue
                    if ( ! isset($combinedQueues[$queueName]))
                    {
                        $combinedQueues[$queueName] = [
                            'name'      => $queueName,
                            'length'    => 0,
                            'wait'      => 0,
                            'processes' => 0,
                        ];
                    }

                    $length = $this->queue->connection($connection)->readyNow($queueName);
                    $combinedQueues[$queueName]['length'] += $length;
                    $combinedQueues[$queueName]['wait'] = max(
                        $combinedQueues[$queueName]['wait'],
                        $waitTime
                    );
                    $combinedQueues[$queueName]['processes'] += $totalProcesses;
                }
            });

        return collect($combinedQueues)
            ->values()
            ->sortBy('name')
            ->all();
    }

    /**
     * Get the number of processes of each queue.
     *
     * @return array
     */
    private function processes(): array
    {
        return collect($this->supervisors->all())->pluck('processes')->reduce(function ($final, $queues) {
            foreach ($queues as $queue => $processes)
            {
                $final[$queue] = isset($final[$queue]) ? $final[$queue] + $processes : $processes;
            }

            return $final;
        }, []);
    }
}
