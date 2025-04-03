<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\CategoryCollection;
use App\Models\Advertise\Category;
use App\Traits\HttpResponses;

class CategoryController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryCollection(Category::whereNull('parent_id')->get());
    }
}
