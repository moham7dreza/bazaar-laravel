<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\MenuCollection;
use App\Models\Content\Menu;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuController extends Controller
{
    public function index(): ResourceCollection
    {
        $menus = Menu::query()->whereNull('parent_id')->get();

        return $menus->toResourceCollection(MenuCollection::class);
    }
}
