<?php

declare(strict_types=1);

namespace Modules\Monitoring\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsFluent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Modules\Monitoring\Enums\CommandLoggingStatus;

class CommandPerformanceLog extends Model
{
    use Prunable;

    protected $guarded = [];

    public function prunable(): Builder
    {
        return self::query()->where('created_at', '<=', now()->subWeeks(2));
    }

    public function scopeRunning($query)
    {
        return $query->where('status', CommandLoggingStatus::Started);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', CommandLoggingStatus::Completed);
    }

    public function scopeFailed($query)
    {
        return $query
            ->where('status', CommandLoggingStatus::Started)
            ->whereDate('created_at', '<', now()->subDays());
    }

    public function getFormattedRuntimeAttribute(): string
    {
        return number_format($this->runtime) . ' ms';
    }

    public function getFormattedMemoryUsageAttribute(): string
    {
        return number_format($this->memory_usage) . ' bytes';
    }

    public function getFormattedQueryTimeAttribute(): string
    {
        return number_format($this->query_time) . ' ms';
    }

    public function isRunning(): bool
    {
        return CommandLoggingStatus::Started === $this->status;
    }

    /** @attribute category */
//    public function getCategoryAttribute(): string
//    {
//        $parts = explode(':', $this->command, 2);
//        return count($parts) > 1 ? $parts[0] : 'general';
//    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('command', 'like', "{$category}%");
    }

    #[Scope]
    protected function highestQueryTime($query, int $count = 1000): Builder
    {
        return $query->where('query_time', '>=', $count);
    }

    protected function casts(): array
    {
        return [
            'inputs' => AsFluent::class,
            'status' => CommandLoggingStatus::class,
        ];
    }
}
