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
class Message extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Prunable;
    // _____________________________________________ use section ________________________________________________
    //
    use SoftDeletes;

    // _____________________________________________ props section ______________________________________________

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

    // _____________________________________________ model related methods section ______________________________

    protected function casts(): array
    {
        return [

        ];
    }

    // _____________________________________________ relations section __________________________________________

    // _____________________________________________ method section __________________________________________

}
