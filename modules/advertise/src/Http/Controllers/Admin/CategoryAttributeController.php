<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Advertise\Http\Requests\Admin\StoreCategoryAttributeRequest;
use Modules\Advertise\Http\Requests\Admin\UpdateCategoryAttributeRequest;
use Modules\Advertise\Models\CategoryAttribute;
use Throwable;

final class CategoryAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return CategoryAttribute::query()->paginate()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryAttributeRequest $request)
    {
        $inputs            = $request->all();
        $categoryAttribute = CategoryAttribute::query()->create($inputs);

        return $categoryAttribute->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryAttribute $categoryAttribute)
    {
        return $categoryAttribute->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryAttributeRequest $request, CategoryAttribute $categoryAttribute)
    {
        $inputs = $request->all();
        $categoryAttribute->update($inputs);

        return $categoryAttribute->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAttribute $categoryAttribute)
    {
        $categoryAttribute->delete();

        return ApiJsonResponse::success(message: 'ویژگی دسته بندی حذف شد');
    }
}
