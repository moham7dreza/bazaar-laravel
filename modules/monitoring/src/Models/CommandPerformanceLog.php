<?php

declare(strict_types=1);

namespace Modules\Monitoring\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Modules\Monitoring\Enums\CommandLoggingStatus;

#[ScopedBy([LatestScope::class])]
final class CommandPerformanceLog extends Model
{
    use Prunable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'inputs' => 'json',
            'status' => CommandLoggingStatus::class,
        ];
    }

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subWeeks(2));
    }

    #[Scope]
    public function highestQueryTime($query, int $count = 1000): Builder
    {
        return $query->where('query_time', '>=', $count);
    }
}
