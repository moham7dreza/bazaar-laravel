<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Advertise\Http\Requests\Admin\StoreCategoryValueRequest;
use Modules\Advertise\Http\Requests\Admin\UpdateCategoryValueRequest;
use Modules\Advertise\Models\CategoryValue;
use Throwable;

final class CategoryValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return CategoryValue::query()->paginate()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryValueRequest $request)
    {
        $inputs        = $request->all();
        $categoryValue = CategoryValue::query()->create($inputs);

        return $categoryValue->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryValue $categoryValue)
    {
        return $categoryValue->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryValueRequest $request, CategoryValue $categoryValue)
    {
        $inputs = $request->all();
        $categoryValue->update($inputs);

        return $categoryValue->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryValue $categoryValue)
    {
        $categoryValue->delete();

        return ApiJsonResponse::success(message: 'مقدار ویژگی دسته بندی حذف شد');
    }
}
