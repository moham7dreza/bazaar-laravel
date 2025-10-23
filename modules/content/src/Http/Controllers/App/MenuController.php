<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Content\Models\Menu;
use Throwable;

final class MenuController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return Menu::query()
            ->whereNull('parent_id')
            ->get()
            ->toResourceCollection();
    }
}
