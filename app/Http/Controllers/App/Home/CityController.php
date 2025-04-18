<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\CityCollection;
use App\Models\Geo\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): CityCollection
    {
        return new CityCollection(City::query()->active()->lazy());
    }
}
