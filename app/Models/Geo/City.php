<?php

declare(strict_types=1);

namespace App\Models\Geo;

use App\Http\Resources\App\CityCollection;
use App\Http\Resources\App\CityResource;
use Database\Factories\Geo\CityFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Models\Advertisement;

#[UseFactory(CityFactory::class)]
#[UseResource(CityResource::class)]
#[UseResourceCollection(CityCollection::class)]
final class City extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________

    protected $guarded = ['id'];

    // _____________________________________________ relations SECTION __________________________________________
    /**
     * @return HasMany<Advertisement, $this>
     */
    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', true);
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
