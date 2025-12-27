<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Region\Models\City;
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
            ->get()
            ->toResourceCollection();
    }
}
