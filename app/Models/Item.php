<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class Item extends Model
{
    use Prunable;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subMonths(6));
    }

    #[Scope]
    protected function active(): Builder
    {
        return $this->where('status', true);
    }

    protected function casts(): array
    {
        return [

        ];
    }
}
