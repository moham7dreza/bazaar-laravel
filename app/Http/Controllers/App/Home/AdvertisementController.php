<?php

namespace App\Http\Controllers\App\Home;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementCollection;
use App\Models\Advertise\Advertisement;

class AdvertisementController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AdvertisementCollection(Advertisement::all());
    }
}
