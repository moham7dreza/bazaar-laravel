<?php

namespace App\Models\Advertise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisementNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
