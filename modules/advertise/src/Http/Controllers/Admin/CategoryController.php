<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;
use Modules\Advertise\Http\Requests\Admin\StoreCategoryRequest;
use Modules\Advertise\Http\Resources\Admin\CategoryResource;
use Modules\Advertise\Models\Category;
use Throwable;

final class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return Category::query()->paginate()->toResourceCollection(CategoryResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $inputs   = $request->all();
        $category = Category::query()->create($inputs);

        return $category->toResource(CategoryResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category->toResource(CategoryResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $inputs = $request->all();
        $category->update($inputs);

        return $category->toResource(CategoryResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return ApiJsonResponse::success(message: 'دسته بندی حذف شد');
    }
}
