<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Modules\Advertise\Models\Category;
use Throwable;

final class CategoryAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function __invoke(Category $category)
    {
        return $category
            ->attributes
            ->toResourceCollection();
    }
}
