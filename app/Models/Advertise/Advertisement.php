<?php

namespace App\Models\Advertise;

use App\Enums\Advertisement\AdvertisementStatus;
use App\Enums\Advertisement\AdvertisementType;
use App\Models\Geo\City;
use App\Models\Scopes\LatestScope;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class Advertisement extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/
    protected $guarded = ['id'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/
    protected function casts(): array
    {
        return [
            'image' => 'array',
            'status' => 'bool',
            'is_special' => 'bool',
            'is_ladder' => 'bool',
            'willing_to_trade' => 'bool',
            'published_at' => 'datetime',
            'expired_at' => 'datetime',
            'ads_type' => AdvertisementType::class,
            'ads_status' => AdvertisementStatus::class,
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    #[Scope]
    public function active(): Builder
    {
        return $this->where('status', true);
    }

    #[Scope]
    public function inCategory($categoryId): Builder
    {
        return $this->where('category_id', $categoryId);
    }

    #[Scope]
    public function priceRange($min = null, $max = null): Builder
    {
        return $this->when($min, function ($query) use ($min) {
            return $query->where('price', '>=', $min);
        })
            ->when($max, function ($query) use ($max) {
                return $query->where('price', '<=', $max);
            });
    }

    #[Scope]
    public function sortBy($sort): Builder
    {
        return $this->when($sort === 'price_asc', function ($query) {
            return $query->orderBy('price', 'asc');
        })
            ->when($sort === 'price_desc', function ($query) {
                return $query->orderBy('price', 'desc');
            })
            ->when($sort === 'newest', function ($query) {
                return $query->orderBy('created_at', 'desc');
            });
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function categoryValues(): BelongsToMany
    {
        return $this->belongsToMany(CategoryValue::class, 'advertisement_category_values')->withTimestamps();
    }

    public function advertisementNotes(): HasMany
    {
        return $this->hasMany(AdvertisementNote::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function viewedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'advertisement_view_history')->withTimestamps();
    }

    /*** _____________________________________________ method SECTION __________________________________________ ***/
}
