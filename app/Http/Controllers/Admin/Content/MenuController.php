<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuRequest;
use App\Http\Requests\Admin\UpdateMenuRequest;
use App\Http\Resources\Admin\Content\MenuCollection;
use App\Http\Resources\Admin\Content\MenuResource;
use App\Models\Content\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new MenuCollection(Menu::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $inputs = $request->all();
        $menu = Menu::create($inputs);
        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $inputs = $request->all();
        $menu->update($inputs);
        return new MenuResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return ['status' => true, 'msg' => 'منو حذف شد'];
    }
}
