<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\PageCollection;
use App\Models\Content\Page;

class PageController extends Controller
{
    public function index()
    {
        return new PageCollection(Page::all());
    }
}
