<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/
    protected $guarded = ['id', 'slug'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    /*** _____________________________________________ method SECTION __________________________________________ ***/

}
