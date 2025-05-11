<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\PageCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Content\Models\Page;

final class PageController extends Controller
{
    public function index(): ResourceCollection
    {
        return Page::all()->toResourceCollection(PageCollection::class);
    }
}
