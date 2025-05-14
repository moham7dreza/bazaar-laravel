<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Resources\App\CategoryResource;
use Modules\Advertise\Models\Category;

final class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $categories = Category::query()->whereNull('parent_id')->get();

        return $categories->toResourceCollection(CategoryResource::class);
    }
}
