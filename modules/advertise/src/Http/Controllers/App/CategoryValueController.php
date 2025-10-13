<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Modules\Advertise\Http\Resources\Admin\CategoryValueResource;
use Modules\Advertise\Models\CategoryAttribute;
use Throwable;

final class CategoryValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function __invoke(CategoryAttribute $categoryAttribute)
    {
        return $categoryAttribute->categoryValues->toResourceCollection(CategoryValueResource::class);
    }
}
