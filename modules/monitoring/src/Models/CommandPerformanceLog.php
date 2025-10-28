<?php

declare(strict_types=1);

namespace Modules\Monitoring\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsFluent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Modules\Monitoring\Enums\CommandLoggingStatus;

class CommandPerformanceLog extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Prunable;

    protected $guarded = [];

    public function prunable(): Builder
    {
        return self::query()->where('created_at', '<=', now()->subWeeks(2));
    }

    public function isRunning(): bool
    {
        return CommandLoggingStatus::Started === $this->status;
    }

    #[Scope]
    protected function running($query)
    {
        return $query->where('status', CommandLoggingStatus::Started);
    }

    #[Scope]
    protected function completed($query)
    {
        return $query->where('status', CommandLoggingStatus::Completed);
    }

    #[Scope]
    protected function failed($query)
    {
        return $query
            ->where('status', CommandLoggingStatus::Started)
            ->whereDate('created_at', '<', now()->subDays());
    }

    protected function formattedRuntime(): Attribute
    {
        return Attribute::make(get: fn () => number_format($this->runtime) . ' ms');
    }

    protected function formattedMemoryUsage(): Attribute
    {
        return Attribute::make(get: fn () => number_format($this->memory_usage) . ' bytes');
    }

    protected function formattedQueryTime(): Attribute
    {
        return Attribute::make(get: fn () => number_format($this->query_time) . ' ms');
    }

    /** @attribute category */
//    public function getCategoryAttribute(): string
//    {
//        $parts = explode(':', $this->command, 2);
//        return count($parts) > 1 ? $parts[0] : 'general';
//    }

    #[Scope]
    protected function byCategory($query, string $category)
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
