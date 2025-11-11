<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Models\Scopes\LatestScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Database\Factories\CategoryFactory;
use Modules\Advertise\Enums\AttributeType;
use Modules\Advertise\Http\Resources\App\CategoryCollection;
use Modules\Advertise\Http\Resources\App\CategoryResource;

#[ScopedBy([LatestScope::class])]
#[UseFactory(CategoryFactory::class)]
#[UseResource(CategoryResource::class)]
#[UseResourceCollection(CategoryCollection::class)]
final class Category extends Model
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

    // _____________________________________________ relations SECTION __________________________________________
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->withDefault(['name' => __('Unknown parent')]);
    }

    /**
     * @return HasMany<Advertisement, $this>
     */
    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    /**
     * @return HasMany<CategoryAttribute, $this>
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    // Category values
    /**
     * @return HasManyThrough<CategoryValue, CategoryAttribute, $this>
     */
    public function values(): HasManyThrough
    {
        return $this->hasManyThrough(
            CategoryValue::class,
            CategoryAttribute::class,
            'category_id',
            'category_attribute_id'
        );
    }

    public function latestValue(): HasOneThrough
    {
        return $this->values()->one()->latestOfMany();
    }

    public function firstValue(): HasOneThrough
    {
        return $this->values()->one()->oldestOfMany();
    }

    public function highestValue(): HasOneThrough
    {
        return $this->values()->one()->where('type', AttributeType::Number)->ofMany([
            'value' => 'max',
        ]);
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // end Category values

    // _____________________________________________ method SECTION __________________________________________

}
