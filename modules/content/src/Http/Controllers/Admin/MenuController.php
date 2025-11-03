<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Content\Http\Requests\Admin\StoreMenuRequest;
use Modules\Content\Http\Requests\Admin\UpdateMenuRequest;
use Modules\Content\Http\Resources\Admin\MenuResource;
use Modules\Content\Models\Menu;
use Throwable;

final class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return Menu::query()->paginate()->toResourceCollection(MenuResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $inputs = $request->all();
        $menu   = Menu::query()->create($inputs);

        return $menu->toResource(MenuResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return $menu->toResource(MenuResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $inputs = $request->all();
        $menu->update($inputs);

        return $menu->toResource(MenuResource::class);
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
