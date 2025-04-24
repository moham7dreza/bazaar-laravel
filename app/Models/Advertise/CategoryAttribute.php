<?php

namespace App\Models\Advertise;

use App\Enums\Advertisement\Unit;
use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class CategoryAttribute extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/
    protected $guarded = ['id'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    protected function casts(): array
    {
        return [
            'unit' => Unit::class,
            'status' => 'boolean',
        ];
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryValues(): HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }

    /*** _____________________________________________ method SECTION __________________________________________ ***/

}
