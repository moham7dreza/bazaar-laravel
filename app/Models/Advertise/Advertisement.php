<?php

namespace App\Models\Advertise;

use App\Enums\Advertisement\AdvertisementStatus;
use App\Enums\Advertisement\AdvertisementType;
use App\Enums\Advertisement\Sort;
use App\Models\Geo\City;
use App\Models\Scopes\LatestScope;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class Advertisement extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use Prunable;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    // _____________________________________________ model related methods SECTION ______________________________
    protected function casts(): array
    {
        return [
            'image'            => 'array',
            'status'           => 'bool',
            'is_special'       => 'bool',
            'is_ladder'        => 'bool',
            'willing_to_trade' => 'bool',
            'published_at'     => 'datetime',
            'expired_at'       => 'datetime',
            'ads_type'         => AdvertisementType::class,
            'ads_status'       => AdvertisementStatus::class,
        ];
    }

    public function prunable(): Builder
    {
        return static::query()->whereDate('created_at', '<=', now()->subMonths(6));
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
    public function inCategory(Builder $builder, int $categoryId): Builder
    {
        return $builder->where('category_id', $categoryId);
    }

    #[Scope]
    public function priceRange(Builder $builder, ?float $min = null, ?float $max = null): Builder
    {
        return $builder->when($min, function (Builder $query) use ($min) {
            return $query->where('price', '>=', $min);
        })
            ->when($max, function (Builder $query) use ($max) {
                return $query->where('price', '<=', $max);
            });
    }

    #[Scope]
    public function sortBy(Builder $builder, Sort $sort): Builder
    {
        return match ($sort) {

            Sort::PRICE_ASC  => $builder->oldest('price'),
            Sort::PRICE_DESC => $builder->latest('price'),
            Sort::NEWEST     => $builder->latest(),
            Sort::OLDEST     => $builder->oldest(),
        };
    }

    #[Scope]
    public function published(): Builder
    {
        return $this->where('published_at', '<', now());
    }

    #[Scope]
    public function popular(): Builder
    {
        return $this->where('views', '>', 1000);
    }

    #[Scope]
    public function withHighEngagement(): Builder
    {
        return $this->popular()
            ->orWhere('is_special', true)
            ->orWhere('is_ladder', true);
    }

    // _____________________________________________ relations SECTION __________________________________________
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault(['name' => __('Unknown category')]);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault(['name' => __('Unknown city')]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name' => trans('Guest author')]);
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

    // _____________________________________________ method SECTION __________________________________________
}
