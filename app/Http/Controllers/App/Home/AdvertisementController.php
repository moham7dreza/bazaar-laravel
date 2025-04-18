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
    public function index(): AdvertisementCollection
    {
        return new AdvertisementCollection(Advertisement::all());
    }

    public function show(Advertisement $advertisement): AdvertisementResource
    {
        $advertisement->increment('view');
        $historyController = new HistoryAdvertisementController;
        $historyController->store($advertisement);

        $advertisement->load([
            'category.parent', 'images', 'category.attributes', 'categoryValues'
        ]);

        $advertisement->refresh();

        return new AdvertisementResource($advertisement);
    }
}
