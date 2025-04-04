<?php

namespace App\Models\Content;

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
class Menu extends Model
{
    use CascadeSoftDeletes;

    /*** _____________________________________________ use SECTION ______________________________________________ ***/
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/
    protected array $cascadeDeletes = ['children'];

    protected $guarded = ['id', 'slug'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id');
    }

    /*** _____________________________________________ methods SECTION ____________________________________________ ***/
}
