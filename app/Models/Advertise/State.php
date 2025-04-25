<?php

namespace App\Models\Advertise;

use App\Models\Scopes\LatestScope;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class State extends Model
{
    use CascadeSoftDeletes;

    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    protected array $cascadeDeletes = ['children'];

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // _____________________________________________ relations SECTION __________________________________________

    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id');
    }

    // _____________________________________________ method SECTION __________________________________________

}
