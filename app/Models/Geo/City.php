<?php

namespace App\Models\Geo;

use App\Models\Advertise\Advertisement;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    #[Scope]
    public function active(Builder $query): Builder
    {
        return $query->where('status', 1);
    }
}
