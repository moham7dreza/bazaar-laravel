<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryValueRequest;
use App\Http\Requests\Admin\UpdateCategoryValueRequest;
use App\Http\Resources\Admin\Advertise\CategoryValueCollection;
use App\Http\Resources\Admin\Advertise\CategoryValueResource;
use App\Http\Responses\ApiJsonResponse;
use Modules\Advertise\Models\CategoryValue;

final class CategoryValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryValueCollection(CategoryValue::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryValueRequest $request)
    {
        $inputs        = $request->all();
        $categoryValue = CategoryValue::create($inputs);

        return new CategoryValueResource($categoryValue);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryValue $categoryValue)
    {
        return new CategoryValueResource($categoryValue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryValueRequest $request, CategoryValue $categoryValue)
    {
        $inputs = $request->all();
        $categoryValue->update($inputs);

        return new CategoryValueResource($categoryValue);
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
