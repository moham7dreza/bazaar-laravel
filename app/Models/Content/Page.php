<?php

namespace App\Models\Content;

use App\Models\Scopes\LatestScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\AsHtmlString;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
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
            'body' => AsHtmlString::class,
        ];
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    /*** _____________________________________________ method SECTION __________________________________________ ***/

}
