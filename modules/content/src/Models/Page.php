<?php

declare(strict_types=1);

namespace Modules\Content\Models;

use App\Models\Scopes\LatestScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Casts\AsHtmlString;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Content\Database\Factories\PageFactory;
use Modules\Content\Http\Resources\App\PageCollection;
use Modules\Content\Http\Resources\App\PageResource;

#[UseFactory(PageFactory::class)]
#[UseResource(PageResource::class)]
#[UseResourceCollection(PageCollection::class)]
#[ScopedBy([LatestScope::class])]
final class Page extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;

    use Sluggable;

    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id', 'slug'];

    // _____________________________________________ model related methods SECTION ______________________________
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
            'body'   => AsHtmlString::class,
        ];
    }

    // _____________________________________________ relations SECTION __________________________________________

    // _____________________________________________ method SECTION __________________________________________

}
