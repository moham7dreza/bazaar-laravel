<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Models\Category;
use Throwable;

final class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return Category::query()
            ->with('advertisements')
            ->has('advertisements')
            ->paginate()
            ->toResourceCollection();
    }
}
