<?php

declare(strict_types=1);

namespace Modules\Region\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tel_prefix',
    ];

    /**
     * @return HasMany<Country, $this>
     */
    public function counties(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    /**
     * @return HasMany<City, $this>
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
