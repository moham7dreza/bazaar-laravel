<?php

namespace App\Models\Advertise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function categoryAttribute()
    {
        return $this->belongsTo(CategoryAttribute::class);
    }
}
