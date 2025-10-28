<?php

declare(strict_types=1);

namespace Modules\Monitoring\Commands;

use Illuminate\Console\Command;
use Modules\Monitoring\Models\CommandPerformanceLog;
use Modules\Monitoring\Services\Command\CommandMonitoringService;

/**
 * # Show failed commands per hour (last 24h)
 * php artisan monitor:commands --failed-per-hour.
 *
 * # Show failed commands for specific category
 * php artisan monitor:commands --failed-per-hour --category=house
 *
 * # Show commands execution rate per minute
 * php artisan monitor:commands --commands-per-minute
 *
 * # Show recent commands (last 20)
 * php artisan monitor:commands --recent
 *
 * # Show recent failed commands only
 * php artisan monitor:commands --recent --category=reserve
 *
 * # Custom limits and filters
 * php artisan monitor:commands --recent --category=house
 * php artisan monitor:commands --commands-per-minute --category=reserve
 * php artisan monitor:commands --failed-per-hour --category=system
 */
class MonitorCommands extends Command
{
    protected $signature = 'monitor:commands
                            {--category= : Filter by category}
                            {--slow : Show only slow commands}
                            {--running : Show only running commands}
                            {--categories : List all categories}
                            {--performance : Show performance trends for a category}
                            {--statistics= : Show statistics for a specific command}
                            {--failed-per-hour : Show failed commands per hour}
                            {--recent : Show recent commands}
                            {--commands-per-minute : Show commands execution rate per minute}';

    protected $description = 'Monitor command performance using command prefixes as categories';

    public function handle(CommandMonitoringService $monitor): int
    {
        if ($this->option('failed-per-hour'))
        {
            $this->showFailedCommandsPerHour($monitor);
        }
        elseif ($this->option('commands-per-minute'))
        {
            $this->showCommandsPerMinute($monitor);
        }
        elseif ($this->option('recent'))
        {
            $this->showRecentCommands($monitor);
        }
        elseif ($this->option('statistics'))
        {
            $this->showCommandStatistics($monitor);
        }
        elseif ($this->option('performance'))
        {
            $this->showCategoryPerformance($monitor);
        }
        elseif ($this->option('categories'))
        {
            $this->showCategories($monitor);
        }
        elseif ($this->option('running'))
        {
            $this->showRunningCommands($monitor);
        }
        elseif ($this->option('slow'))
        {
            $this->showSlowCommands($monitor);
        }
        elseif ($this->option('category'))
        {
            $this->showCategoryDetails($monitor);
        }
        else
        {
            $this->showWorkloadOverview($monitor);
        }

        return static::SUCCESS;
    }

    protected function showFailedCommandsPerHour(CommandMonitoringService $monitor): void
    {
        $hours    = $this->ask('Analyze last how many hours?', 24);
        $category = $this->option('category');

        $failedData = $monitor->getFailedCommandsPerHour($hours, $category);

        $title = $category
            ? "Failed Commands Per Hour - Category: {$category} (Last {$hours}h)"
            : "Failed Commands Per Hour (Last {$hours}h)";

        $this->components->info($title);
        $this->components->info(str_repeat('=', mb_strlen($title)));

        if ($failedData->isEmpty())
        {
            $this->info('🎉 No failed commands found in the specified period.');

            return;
        }

        $totalFailed = $failedData->sum('failed_count');
        $peakHour    = $failedData->sortByDesc('failed_count')->first();

        $this->components->info("\n📈 Summary:");
        $this->components->line("Total Failed Commands: <comment>{$totalFailed}</comment>");
        $this->components->line("Peak Failure Hour: <comment>{$peakHour->hour} - {$peakHour->failed_count} failures</comment>");
        $this->components->line('Average Failures/Hour: <comment>' . number_format($totalFailed / $failedData->count(), 1) . '</comment>');

        $this->components->info("\n🕒 Hourly Breakdown:");

        $rows = $failedData->map(function ($hour) {
            $trend = $hour->failed_count > 5 ? '🔴' : ($hour->failed_count > 2 ? '🟡' : '🟢');

            return [
                $hour->hour,
                "{$trend} {$hour->failed_count}",
                $hour->most_failed_command ?: 'N/A',
                $hour->failed_count > 0 ? number_format($hour->failure_rate * 100, 1) . '%' : '0%',
            ];
        });

        $this->table(['Hour', 'Failures', 'Most Failed Command', 'Failure Rate'], $rows);

        // Show top failing commands
        $topFailing = $monitor->getTopFailingCommands($hours, $category);

        if ($topFailing->isNotEmpty())
        {
            $this->info("\n🚨 Top Failing Commands:");
            $topFailing->each(function ($command): void {
                $this->line(" - <comment>{$command->command}</comment>: {$command->failure_count} failures");
            });
        }
    }

    protected function showCommandsPerMinute(CommandMonitoringService $monitor): void
    {
        $minutes  = $this->ask('Analyze last how many minutes?', 60);
        $category = $this->option('category');

        $rateData = $monitor->getCommandsPerMinute($minutes, $category);

        $title = $category
            ? "Commands Execution Rate - Category: {$category} (Last {$minutes}m)"
            : "Commands Execution Rate (Last {$minutes}m)";

        $this->components->info($title);
        $this->components->info(str_repeat('=', mb_strlen($title)));

        if ($rateData->isEmpty())
        {
            $this->info('No command executions found in the specified period.');

            return;
        }

        $totalCommands = $rateData->sum('command_count');
        $peakMinute    = $rateData->sortByDesc('command_count')->first();
        $avgPerMinute  = $totalCommands / $rateData->count();

        $this->components->info("\n📈 Summary:");
        $this->components->line("Total Commands Executed: <comment>{$totalCommands}</comment>");
        $this->components->line("Peak Execution: <comment>{$peakMinute->minute} - {$peakMinute->command_count} commands</comment>");
        $this->components->line('Average Rate: <comment>' . number_format($avgPerMinute, 1) . ' commands/minute</comment>');

        $this->components->info("\n⏱️  Minute-by-Minute Rate:");

        // Group by 5-minute intervals for better readability
        $groupedData = $rateData->groupBy(function ($item) {
            return mb_substr($item->minute, 0, 15) . '0'; // Group by 10-minute intervals
        })->map(fn ($group) => (object) [
            'interval'       => $group->first()->minute,
            'total_commands' => $group->sum('command_count'),
            'avg_commands'   => $group->avg('command_count'),
        ]);

        $rows = $groupedData->map(function ($interval) use ($avgPerMinute) {
            $trend = $interval->avg_commands > $avgPerMinute * 1.5 ? '🚀' :
                ($interval->avg_commands < $avgPerMinute * 0.5 ? '🐢' : '➡️');

            return [
                $interval->interval,
                "{$trend} {$interval->total_commands}",
                number_format($interval->avg_commands, 1),
                $this->getTrafficLight($interval->avg_commands, $avgPerMinute),
            ];
        });

        $this->table(['Time Interval', 'Total Commands', 'Avg/Min', 'Load'], $rows);

        // Show busiest minutes
        $busiestMinutes = $rateData->sortByDesc('command_count')->take(5);
        $this->components->info("\n🔥 Busiest Minutes:");
        $busiestMinutes->each(function ($minute): void {
            $this->line(" - <comment>{$minute->minute}</comment>: {$minute->command_count} commands");
        });
    }

    protected function showRecentCommands(CommandMonitoringService $monitor): void
    {
        $limit    = $this->ask('How many recent commands to show?', 20);
        $category = $this->option('category');
        $status   = $this->choice('Filter by status?', ['all', 'completed', 'failed', 'running'], 'all');

        $recentCommands = $monitor->getRecentCommands($limit, $category, $status);

        $title = 'Recent Commands' .
            ($category ? " - Category: {$category}" : '') .
            ('all' !== $status ? " - Status: {$status}" : '');

        $this->components->info($title);
        $this->components->info(str_repeat('=', mb_strlen($title)));

        if ($recentCommands->isEmpty())
        {
            $this->info('No commands found matching the criteria.');

            return;
        }

        $rows = $recentCommands->map(function ($command) {
            $statusIcon = match($command->status)
            {
                'completed' => '🟢',
                'failed'    => '🔴',
                'started'   => '🟡',
                default     => '⚪'
            };

            $duration = $command->completed_at
                ? $command->started_at->diffInSeconds($command->completed_at) . 's'
                : 'running';

            return [
                $statusIcon,
                $command->command,
                $command->category,
                $command->formatted_runtime,
                $command->query_count,
                $duration,
                $command->created_at->diffForHumans(),
            ];
        });

        $this->table(['Status', 'Command', 'Category', 'Runtime', 'Queries', 'Duration', 'Run Time'], $rows);

        // Summary
        $completed = $recentCommands->where('status', 'completed')->count();
        $failed    = $recentCommands->where('status', 'failed')->count();
        $running   = $recentCommands->where('status', 'started')->count();

        $this->components->info("\n📊 Summary of Last {$limit} Commands:");
        $this->components->line("Completed: <fg=green>{$completed}</> | Failed: <fg=red>{$failed}</> | Running: <fg=yellow>{$running}</>");

        if ($failed > 0)
        {
            $failureRate = ($failed / $recentCommands->count()) * 100;
            $this->line('Failure Rate: <fg=red>' . number_format($failureRate, 1) . '%</>');
        }
    }

    protected function showCommandStatistics(CommandMonitoringService $monitor): void
    {
        $commandName = $this->option('statistics');
        $statistics  = $monitor->getCommandStatistics($commandName);

        $this->components->info("Statistics for: {$commandName}");
        $this->components->info('==================' . str_repeat('=', mb_strlen($commandName)));

        if ( ! \Illuminate\Support\Arr::get($statistics, 'statistics') || 0 === \Illuminate\Support\Arr::get($statistics, 'statistics')->total_runs)
        {
            $this->error("No data found for command: {$commandName}");

            return;
        }

        $stats = \Illuminate\Support\Arr::get($statistics, 'statistics');

        // Display summary statistics
        $this->components->info("\n📊 Summary Statistics:");
        $this->components->line("Total Runs: <comment>{$stats->total_runs}</comment>");
        $this->components->line('Average Runtime: <comment>' . number_format($stats->avg_runtime) . ' ms</comment>');
        $this->components->line('Min Runtime: <comment>' . number_format($stats->min_runtime) . ' ms</comment>');
        $this->components->line('Max Runtime: <comment>' . number_format($stats->max_runtime) . ' ms</comment>');
        $this->components->line('Average Memory: <comment>' . number_format($stats->avg_memory) . ' bytes</comment>');
        $this->components->line('Average Queries: <comment>' . number_format($stats->avg_queries) . '</comment>');

        // Display recent runs
        $this->components->info("\n🕒 Recent Runs (Last 10):");

        if (\Illuminate\Support\Arr::get($statistics, 'recent_runs')->isEmpty())
        {
            $this->line('No recent runs found.');

            return;
        }

        $rows = \Illuminate\Support\Arr::get($statistics, 'recent_runs')->map(function (CommandPerformanceLog $run) {
            $status = ! $run->isRunning()
                ? '<fg=green>✓</>'
                : '<fg=red>✗</>';

            return [
                $status,
                $run->formatted_runtime,
                $run->formatted_memory_usage,
                $run->query_count,
                $run->updated_at->format('Y-m-d H:i'),
            ];
        });

        $this->table(['Status', 'Runtime', 'Memory', 'Queries', 'Completed'], $rows);
    }

    protected function showCategoryPerformance(CommandMonitoringService $monitor): void
    {
        $category = $this->option('category') ?? $this->ask('Enter category name');

        if ( ! $category)
        {
            $this->error('Category is required for performance analysis');

            return;
        }

        $days        = $this->ask('Number of days to analyze', 30);
        $performance = $monitor->getCategoryPerformance($category, $days);

        $this->components->info("Performance Trends for Category: {$category} (Last {$days} days)");
        $this->components->info('==========================================' . str_repeat('=', mb_strlen($category) + mb_strlen($days)));

        if ($performance->isEmpty())
        {
            $this->warn("No performance data found for category: {$category} in the last {$days} days");

            return;
        }

        // Summary statistics
        $totalExecutions = $performance->sum('executions');
        $avgRuntime      = $performance->avg('avg_runtime');
        $avgMemory       = $performance->avg('avg_memory');

        $this->components->info("\n📈 Summary:");
        $this->components->line("Total Executions: <comment>{$totalExecutions}</comment>");
        $this->components->line('Average Runtime: <comment>' . number_format($avgRuntime) . ' ms</comment>');
        $this->components->line('Average Memory: <comment>' . number_format($avgMemory) . ' bytes</comment>');

        // Daily performance table
        $this->components->info("\n📅 Daily Performance:");

        $rows = $performance->map(fn ($day) => [
            $day->date,
            $day->executions,
            number_format($day->avg_runtime) . ' ms',
            number_format($day->avg_memory) . ' bytes',
            number_format($day->avg_queries),
        ]);

        $this->table(['Date', 'Executions', 'Avg Runtime', 'Avg Memory', 'Avg Queries'], $rows);

        // Performance trends analysis
        $this->components->info("\n📊 Trends Analysis:");

        $minRuntime = $performance->min('avg_runtime');
        $maxRuntime = $performance->max('avg_runtime');
        $trend      = $this->calculateTrend($performance->pluck('avg_runtime')->toArray());

        $this->components->line('Best Runtime: <comment>' . number_format($minRuntime) . ' ms</comment>');
        $this->components->line('Worst Runtime: <comment>' . number_format($maxRuntime) . ' ms</comment>');
        $this->components->line("Performance Trend: <comment>{$trend}</comment>");
    }

    protected function calculateTrend(array $runtimes): string
    {
        if (count($runtimes) < 2)
        {
            return 'Insufficient data';
        }

        $firstHalf  = array_slice($runtimes, 0, ceil(count($runtimes) / 2));
        $secondHalf = array_slice($runtimes, floor(count($runtimes) / 2));

        $firstAvg  = array_sum($firstHalf)  / count($firstHalf);
        $secondAvg = array_sum($secondHalf) / count($secondHalf);

        $change = (($secondAvg - $firstAvg) / $firstAvg) * 100;

        if ($change > 10)
        {
            return '📈 Getting slower (+' . number_format($change, 1) . '%)';
        }
        if ($change < -10)
        {
            return '📉 Getting faster (' . number_format($change, 1) . '%)';
        }

            return '➡️ Stable (' . number_format($change, 1) . '%)';

    }

    protected function showCategories(CommandMonitoringService $monitor): void
    {
        $categories = $monitor->getCategories();

        $this->components->info('Available Command Categories');
        $this->components->info('============================');

        foreach ($categories as $category)
        {
            $this->line("- {$category}");
        }
    }

    protected function showWorkloadOverview(CommandMonitoringService $monitor): void
    {
        $workload = $monitor->getCategoryWorkload();

        $this->components->info('Command Workload Overview');
        $this->components->info('=========================');

        $rows = $workload->map(fn ($data) => [
            $data->category,
            $data->total_commands,
            $data->running_commands,
            $data->completed_commands,
            $data->failed_commands,
            number_format($data->avg_runtime) . ' ms',
            number_format($data->max_runtime) . ' ms',
        ]);

        $this->table([
            'Category',
            'Total',
            'Running',
            'Completed',
            'Failed',
            'Avg Runtime',
            'Max Runtime',
        ], $rows);
    }

    protected function showRunningCommands(CommandMonitoringService $monitor): void
    {
        $running = $monitor->getRunningCommands();

        $this->components->info('Currently Running Commands');
        $this->components->info('==========================');

        if ($running->isEmpty())
        {
            $this->info('No commands currently running.');

            return;
        }

        $rows = $running->map(fn (CommandPerformanceLog $command) => [
            $command->id,
            $command->command,
            //                $command->category,
            $command->created_at->diffForHumans(),
            $command->formatted_memory_usage,
        ]);

        $this->table(['ID', 'Command',
            //            'Category',
            'Started', 'Memory'], $rows);
    }

    protected function showSlowCommands(CommandMonitoringService $monitor): void
    {
        $category     = $this->option('category');
        $slowCommands = $monitor->getSlowCommands($category);

        $title = $category
            ? "Slow Commands in Category: {$category}"
            : 'Slow Commands (> 5 minutes)';

        $this->components->info($title);
        $this->components->info(str_repeat('=', mb_strlen($title)));

        if ($slowCommands->isEmpty())
        {
            $this->info('No slow commands found.');

            return;
        }

        $rows = $slowCommands->map(fn (CommandPerformanceLog $command) => [
            $command->command,
            //                $command->category,
            $command->formatted_runtime,
            $command->formatted_memory_usage,
            $command->formatted_query_time,
            $command->query_count,
            $command->updated_at->format('Y-m-d H:i'),
        ]);

        $this->table([
            'Command',
            //            'Category',
            'Runtime',
            'Memory',
            'Query Time',
            'Query Count',
            'Completed',
        ], $rows);
    }

    protected function showCategoryDetails(CommandMonitoringService $monitor): void
    {
        $category = $this->option('category');
        $commands = $monitor->getCommandsByCategory($category);

        $this->components->info("Commands in Category: {$category}");
        $this->components->info('==============================' . str_repeat('=', mb_strlen($category)));

        if ($commands->isEmpty())
        {
            $this->info("No commands found in category: {$category}");

            return;
        }

        $rows = $commands->take(20)->map(function (CommandPerformanceLog $command) {
            $status = $command->isRunning()
                ? '<fg=yellow>RUNNING</>'
                : '<fg=green>COMPLETED</>';

            return [
                $command->id,
                $command->command,
                $status,
                $command->formatted_runtime,
                $command->formatted_memory_usage,
                $command->created_at->format('Y-m-d H:i'),
            ];
        });

        $this->table(['ID', 'Command', 'Status', 'Runtime', 'Memory', 'Run At'], $rows);

        if ($commands->count() > 20)
        {
            $this->info("\nShowing 20 of {$commands->count()} commands. Use --category={$category} with other filters to see more.");
        }
    }

    private function getTrafficLight(float $current, float $average): string
    {
        if ($current > $average * 2)
        {
        return '🔴 High';
        }
        if ($current > $average * 1.2)
        {
        return '🟡 Medium';
        }

        return '🟢 Normal';
    }
}
