<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Content\Models\Page;
use Throwable;

final class PageController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return Page::query()
            ->paginate(10)
            ->toResourceCollection();
    }
}
