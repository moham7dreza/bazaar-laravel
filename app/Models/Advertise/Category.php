<?php

namespace App\Models\Advertise;

use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use CascadeSoftDeletes, HasFactory, Sluggable, SoftDeletes;

    protected $cascadeDeletes = ['children'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    protected $guarded = ['id', 'slug'];

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }
}
