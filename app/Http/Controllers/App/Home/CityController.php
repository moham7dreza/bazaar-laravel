<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Models\Geo\City;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Throwable;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return City::query()
            ->active()
            ->get()
            ->toResourceCollection();
    }
}
