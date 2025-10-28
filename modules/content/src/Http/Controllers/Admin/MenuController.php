<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Content\Http\Requests\Admin\StoreMenuRequest;
use Modules\Content\Http\Requests\Admin\UpdateMenuRequest;
use Modules\Content\Http\Resources\Admin\MenuCollection;
use Modules\Content\Http\Resources\Admin\MenuResource;
use Modules\Content\Models\Menu;

final class MenuController extends Controller
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
        $menu   = Menu::query()->create($inputs);

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

        return ApiJsonResponse::success(message: 'منو حذف شد');
    }
}
