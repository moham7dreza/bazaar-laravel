<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Concerns\ClearsResponseCache;
use App\Models\Geo\City;
use App\Models\Scopes\LatestScope;
use App\Models\Traits\Attributable;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Database\Factories\AdvertisementFactory;
use Modules\Advertise\Enums\AdvertisementPublishStatus;
use Modules\Advertise\Enums\AdvertisementStatus;
use Modules\Advertise\Enums\AdvertisementType;
use Modules\Advertise\Enums\Sort;
use Modules\Advertise\Http\Resources\App\AdvertisementCollection;
use Modules\Advertise\Http\Resources\App\AdvertisementResource;
use Modules\Advertise\Policies\AdvertisementPolicy;

#[UsePolicy(AdvertisementPolicy::class)]
#[UseFactory(AdvertisementFactory::class)]
#[UseResource(AdvertisementResource::class)]
#[UseResourceCollection(AdvertisementCollection::class)]
#[ScopedBy([LatestScope::class])]
final class Advertisement extends Model
{
    use Attributable;
    use CascadeSoftDeletes;
    use ClearsResponseCache;
    use HasFactory;
    use Prunable;
    use Sluggable;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function prunable(): Builder
    {
        return self::query()->whereDate('created_at', '<=', now()->subMonths(6));
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault(['name' => __('Unknown category')]);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault(['name' => __('Unknown city')]);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name' => trans('Guest author')]);
    }

    /**
     * @return BelongsToMany<User, $this, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @return BelongsToMany<CategoryValue, $this, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function categoryValues(): BelongsToMany
    {
        return $this->belongsToMany(CategoryValue::class, 'advertisement_category_values')->withTimestamps();
    }

    /**
     * @return HasMany<AdvertisementNote, $this>
     */
    public function advertisementNotes(): HasMany
    {
        return $this->hasMany(AdvertisementNote::class);
    }

    /**
     * @return HasMany<Gallery, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * @return BelongsToMany<User, $this, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function viewedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'advertisement_view_history')->withTimestamps();
    }

    /**
     * @return HasManyThrough<CategoryAttribute, Category, $this>
     */
    public function categoryAttributes(): HasManyThrough
    {
        return $this->hasManyThrough(
            CategoryAttribute::class,
            Category::class,
            'category_id',
            'id',
        );
    }

    #[Scope]
    protected function forAuth(): Builder
    {
        return $this->whereBelongsTo(auth()->user());
    }

    #[Scope]
    protected function active(): Builder
    {
        return $this->where('status', true);
    }

    #[Scope]
    protected function inCategory(Builder $builder, int $categoryId): Builder
    {
        return $builder->where('category_id', $categoryId);
    }

    #[Scope]
    protected function priceRange(Builder $builder, ?float $min = null, ?float $max = null): Builder
    {
        return $builder->when($min, fn (Builder $query) => $query->where('price', '>=', $min))
            ->when($max, fn (Builder $query) => $query->where('price', '<=', $max));
    }

    #[Scope]
    protected function sortBy(Builder $builder, Sort $sort): Builder
    {
        return match ($sort)
        {
            Sort::PRICE_ASC  => $builder->oldest('price'),
            Sort::PRICE_DESC => $builder->latest('price'),
            Sort::NEWEST     => $builder->latest(),
            Sort::OLDEST     => $builder->oldest(),
        };
    }

    #[Scope]
    protected function published(): Builder
    {
        return $this->where('published_at', '<', now());
    }

    #[Scope]
    protected function popular(): Builder
    {
        return $this->where('views', '>', 1000);
    }

    #[Scope]
    protected function withHighEngagement(): Builder
    {
        return $this->popular()
            ->orWhere('is_special', true)
            ->orWhere('is_ladder', true);
    }

    protected function casts(): array
    {
        return [
            'image'            => 'array',
            'status'           => AdvertisementPublishStatus::class,
            'is_special'       => 'bool',
            'is_ladder'        => 'bool',
            'willing_to_trade' => 'bool',
            'published_at'     => 'datetime',
            'expired_at'       => 'datetime',
            //            'ads_type'         => AdvertisementType::class,
            'ads_status'       => AdvertisementStatus::class,
        ];
    }
}
