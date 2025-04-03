<?php

namespace App\Traits;

use Cviebrock\EloquentSluggable\Sluggable;

trait HasSlug
{
    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
