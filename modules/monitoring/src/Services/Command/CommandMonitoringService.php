<?php

declare(strict_types=1);

namespace Modules\Monitoring\Services\Command;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Modules\Monitoring\Models\CommandPerformanceLog;

class CommandMonitoringService
{
    public function getCategories(): Collection
    {
        return CommandPerformanceLog::query()
            ->select(DB::raw("SUBSTRING_INDEX(command, ':', 1) as category"))
            ->distinct()
            ->oldest('category')
            ->pluck('category');
    }

    public function getCategoryWorkload(): Collection
    {
        return CommandPerformanceLog::query()
            ->select(DB::raw("SUBSTRING_INDEX(command, ':', 1) as category"))
            ->selectRaw('COUNT(*) as total_commands')
            ->selectRaw('SUM(CASE WHEN status = "started" THEN 1 ELSE 0 END) as running_commands')
            ->selectRaw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_commands')
            ->selectRaw('AVG(runtime) as avg_runtime')
            ->selectRaw('MAX(runtime) as max_runtime')
            ->groupBy('category')
            ->oldest('category')
            ->get();
    }

    public function getRunningCommands(): Collection
    {
        return CommandPerformanceLog::running()
            ->latest()
            ->get();
    }

    public function getCommandsByCategory(string $category): Collection
    {
        return CommandPerformanceLog::byCategory($category)
            ->latest()
            ->get();
    }

    public function getCategoryPerformance(string $category, int $days = 30): Collection
    {
        return CommandPerformanceLog::byCategory($category)
            ->completed()
            ->where('updated_at', '>=', Date::now()->subDays($days))
            ->select([
                DB::raw('DATE(updated_at) as date'),
                DB::raw('COUNT(*) as executions'),
                DB::raw('AVG(runtime) as avg_runtime'),
                DB::raw('AVG(memory_usage) as avg_memory'),
                DB::raw('AVG(query_count) as avg_queries'),
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getSlowCommands(?string $category = null, int $threshold = 300000): Collection
    {
        $query = CommandPerformanceLog::completed()
            ->where('runtime', '>', $threshold)
            ->orderBy('runtime', 'desc');

        if ($category)
        {
            $query->byCategory($category);
        }

        return $query->get();
    }

    public function getCommandStatistics(string $commandName): array
    {
        $stats = CommandPerformanceLog::query()->where('command', $commandName)
            ->completed()
            ->select([
                DB::raw('COUNT(*) as total_runs'),
                DB::raw('AVG(runtime) as avg_runtime'),
                DB::raw('MIN(runtime) as min_runtime'),
                DB::raw('MAX(runtime) as max_runtime'),
                DB::raw('AVG(memory_usage) as avg_memory'),
                DB::raw('AVG(query_count) as avg_queries'),
            ])
            ->first();

        $lastRuns = CommandPerformanceLog::query()->where('command', $commandName)
            ->completed()
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return [
            'statistics'  => $stats,
            'recent_runs' => $lastRuns,
        ];
    }

    public function getFailedCommandsPerHour(int $hours = 24, ?string $category = null): Collection
    {
        $query = CommandPerformanceLog::failed()
            ->where('created_at', '>=', Date::now()->subHours($hours))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00') as hour"),
                DB::raw('COUNT(*) as failed_count'),
                DB::raw('MAX(command) as most_failed_command'),
                DB::raw('COUNT(*) / (SELECT COUNT(*) FROM command_performance_logs sub WHERE DATE_FORMAT(sub.created_at, "%Y-%m-%d %H:00") = hour AND status != "started") as failure_rate')
            )
            ->groupBy('hour')
            ->orderBy('hour');

        if ($category)
        {
            $query->where('command', 'like', "{$category}:%");
        }

        return $query->get();
    }

    public function getTopFailingCommands(int $hours, ?string $category = null)
    {
        $query = CommandPerformanceLog::failed()
            ->where('created_at', '>=', Date::now()->subHours($hours))
            ->select(
                'command',
                DB::raw('COUNT(*) as failure_count')
            )
            ->groupBy('command')
            ->orderByDesc('failure_count')
            ->limit(5);

        if ($category)
        {
            $query->where('command', 'like', "{$category}:%");
        }

        return $query->get();
    }

    public function getCommandsPerMinute(int $minutes = 60, ?string $category = null): Collection
    {
        $query = CommandPerformanceLog::query()->where('created_at', '>=', Date::now()->subMinutes($minutes))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as minute"),
                DB::raw('COUNT(*) as command_count')
            )
            ->groupBy('minute')
            ->orderBy('minute');

        if ($category)
        {
            $query->whereLike('command', "{$category}:%");
        }

        return $query->get();
    }

    public function getRecentCommands(int $limit = 20, ?string $category = null, string $status = 'all'): Collection
    {
        $query = CommandPerformanceLog::query();

        if ($category)
        {
            $query->whereLike('command', "{$category}:%");
        }

        if ('all' !== $status)
        {
            $query->where('status', $status);
        }

        return $query->latest()
            ->limit($limit)
            ->get();
    }
}
