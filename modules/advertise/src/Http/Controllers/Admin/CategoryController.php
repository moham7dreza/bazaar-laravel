<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Advertise\CategoryCollection;
use App\Http\Resources\Admin\Advertise\CategoryResource;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;
use Modules\Advertise\Http\Requests\Admin\StoreCategoryRequest;
use Modules\Advertise\Models\Category;

final class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $inputs   = $request->all();
        $category = Category::create($inputs);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $inputs = $request->all();
        $category->update($inputs);

        return new CategoryResource($category);
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
