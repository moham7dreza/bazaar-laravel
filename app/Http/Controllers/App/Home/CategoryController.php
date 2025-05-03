<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\CategoryCollection;
use App\Models\Advertise\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $categories = Category::query()->whereNull('parent_id')->get();

        return $categories->toResourceCollection(CategoryCollection::class);
    }
}
