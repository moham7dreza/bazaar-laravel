<?php

namespace App\Models\Advertise;

use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'image' => 'array',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function categoryValues()
    {
        return $this->belongsToMany(CategoryValue::class, 'advertisement_category_values')->withTimestamps();
    }

    public function advertisementNotes()
    {
        return $this->hasMany(AdvertisementNote::class);
    }

    public function images()
    {
        return $this->hasMany(Gallery::class);
    }

    public function viewedByUsers()
    {
        return $this->belongsToMany(User::class, 'advertisement_view_history')->withTimestamps();
    }
}
