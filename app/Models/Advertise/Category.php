<?php

namespace App\Models\Advertise;

use App\Models\Scopes\LatestScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class Category extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use CascadeSoftDeletes;
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id', 'slug'];

    protected array $cascadeDeletes = ['children'];

    // _____________________________________________ model related methods SECTION ______________________________

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

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
        return $this->belongsTo($this, 'parent_id')->withDefault(['name' => __('Unknown parent')]);
    }

    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    // _____________________________________________ method SECTION __________________________________________

}
