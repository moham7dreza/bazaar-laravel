<?php

namespace App\Models\Advertise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function categoryAttribute()
    {
        return $this->belongsTo(CategoryAttribute::class);
    }

    public function advertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_category_values')->withTimestamps();
    }
}
