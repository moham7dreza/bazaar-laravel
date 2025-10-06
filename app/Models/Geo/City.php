<?php

declare(strict_types=1);

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Models\Advertisement;

final class City extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________

    protected $guarded = ['id'];

    // _____________________________________________ relations SECTION __________________________________________

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
