<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Content\Http\Resources\App\PageResource;
use Modules\Content\Models\Page;

final class PageController extends Controller
{
    public function index(): ResourceCollection
    {
        return Page::all()->toResourceCollection(PageResource::class);
    }
}
