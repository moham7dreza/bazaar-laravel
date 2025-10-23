<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Models\Scopes\LatestScope;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Database\Factories\StateFactory;
use Modules\Advertise\Http\Resources\App\StateCollection;
use Modules\Advertise\Http\Resources\App\StateResource;

#[ScopedBy([LatestScope::class])]
#[UseFactory(StateFactory::class)]
#[UseResource(StateResource::class)]
#[UseResourceCollection(StateCollection::class)]
final class State extends Model
{
    use CascadeSoftDeletes;

    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    protected array $cascadeDeletes = ['children'];

    // _____________________________________________ relations SECTION __________________________________________

    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->withDefault(['name' => __('Unknown state')]);
    }

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // _____________________________________________ method SECTION __________________________________________

}
