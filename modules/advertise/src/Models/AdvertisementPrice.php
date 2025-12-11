<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Enums\Currency;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Advertise\Database\Factories\AdvertisementPriceFactory;
use Override;

#[UseFactory(AdvertisementPriceFactory::class)]
class AdvertisementPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'price',
        'currency',
    ];

    /**
     * @return BelongsTo<Advertisement, $this>
     */
    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        // use AdvertisementPriceCreateService
        // static::creating(static fn (self $model) => $model->currency = Currency::currentCurrency());

        static::addGlobalScope('currency', static fn (Builder $builder) => $builder->where('currency', Currency::currentCurrency()));
    }

    #[Scope]
    protected function priceRange(Builder $builder, ?float $min = null, ?float $max = null): Builder
    {
        return $builder
            ->when($min, fn (Builder $query) => $query->where('price', '>=', $min))
            ->when($max, fn (Builder $query) => $query->where('price', '<=', $max));
    }

    protected function casts(): array
    {
        return [
            'price'    => MoneyIntegerCast::class . ':currency',
            'currency' => Currency::class,
        ];
    }
}
