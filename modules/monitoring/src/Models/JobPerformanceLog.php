<?php

declare(strict_types=1);

namespace Modules\Monitoring\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Date;

#[ScopedBy([LatestScope::class])]
final class JobPerformanceLog extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Prunable;

    public const UPDATED_AT = null;

    protected $guarded = [];

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', Date::now()->subWeeks(2));
    }

    #[Scope]
    protected function highestQueryTime($query, int $count = 1000): Builder
    {
        return $query->where('query_time', '>=', $count);
    }
}
