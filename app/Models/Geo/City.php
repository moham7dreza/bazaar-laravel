<?php

namespace App\Models\Geo;

use App\Models\Advertise\Advertisement;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
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
            'status' => 'boolean',
        ];
    }

    #[Scope]
    public function active(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    /*** _____________________________________________ method SECTION __________________________________________ ***/

}
