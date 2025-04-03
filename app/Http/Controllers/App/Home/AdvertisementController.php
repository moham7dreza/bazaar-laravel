<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\App\Panel\HistoryAdvertisementController;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Resources\App\AdvertisementResource;
use App\Models\Advertise\Advertisement;
use App\Traits\HttpResponses;

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

    public function show(Advertisement $advertisement)
    {
        $advertisement->increment('view');
        $hisotryController = new HistoryAdvertisementController;
        $hisotryController->store($advertisement);
        $advertisement = Advertisement::with('category.parent', 'images', 'category.attributes', 'categoryValues')->find($advertisement->id);

        return new AdvertisementResource($advertisement);
    }
}
