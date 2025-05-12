<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Content\Http\Resources\App\MenuCollection;
use Modules\Content\Models\Menu;

final class MenuController extends Controller
{
    public function index(): ResourceCollection
    {
        $menus = Menu::query()->whereNull('parent_id')->get();

        return $menus->toResourceCollection(MenuCollection::class);
    }
}
