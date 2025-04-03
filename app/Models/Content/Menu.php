<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use CascadeSoftDeletes, HasFactory, Sluggable, SoftDeletes;

    protected $cascadeDeletes = ['children'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
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
        return $this->hasOne($this, 'parent_id');
    }
}
