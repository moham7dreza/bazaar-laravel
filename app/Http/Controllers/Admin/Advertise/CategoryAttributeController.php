<?php

namespace App\Http\Controllers\Admin\Advertise;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryAttributeRequest;
use App\Http\Requests\Admin\UpdateCategoryAttributeRequest;
use App\Http\Resources\Admin\Advertise\CategoryAttributeCollection;
use App\Http\Resources\Admin\Advertise\CategoryAttributeResource;
use App\Models\Advertise\CategoryAttribute;

class CategoryAttributeController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryAttributeCollection(CategoryAttribute::all());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryAttributeRequest $request)
    {
        $inputs = $request->all();
        $categoryAttribute = CategoryAttribute::create($inputs);
        return new CategoryAttributeResource($categoryAttribute);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryAttribute $categoryAttribute)
    {
        return new CategoryAttributeResource($categoryAttribute);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryAttributeRequest $request, CategoryAttribute $categoryAttribute)
    {
        $inputs = $request->all();
        $categoryAttribute->update($inputs);
        return new CategoryAttributeResource($categoryAttribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAttribute $categoryAttribute)
    {
        $categoryAttribute->delete();
        // return ['status' => true, 'msg' => 'دسته بندی حذف شد'];
        return $this->success(null, 'ویژگی دسته بندی حذف شد');
    }
}
