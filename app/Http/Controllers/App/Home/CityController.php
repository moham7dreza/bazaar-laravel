<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\CityCollection;
use App\Models\Geo\City;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $cities = City::query()->active()->get();

        return $cities->toResourceCollection(CityCollection::class);
    }
}
