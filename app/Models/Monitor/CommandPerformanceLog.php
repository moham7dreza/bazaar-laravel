<?php

namespace App\Models\Monitor;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

#[ScopedBy([LatestScope::class])]
class CommandPerformanceLog extends Model
{
    use Prunable;

    public const UPDATED_AT = null;

    protected $guarded = [];

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(14));
    }

    #[Scope]
    public function highestQueryTime($query, int $count = 1000): Builder
    {
        return $query->where('query_time', '>=', $count);
    }
}
