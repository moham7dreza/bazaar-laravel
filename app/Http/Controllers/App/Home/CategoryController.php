<?php

namespace App\Http\Controllers\App\Home;

use App\Traits\HttpResponses;
use App\Models\Advertise\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\CategoryCollection;

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
