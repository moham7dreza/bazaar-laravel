<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\PageCollection;
use App\Models\Content\Page;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PageController extends Controller
{
    public function index(): ResourceCollection
    {
        return Page::all()->toResourceCollection(PageCollection::class);
    }
}
