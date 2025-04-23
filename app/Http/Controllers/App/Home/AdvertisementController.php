<?php

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\App\Panel\HistoryAdvertisementController;
use App\Http\Controllers\Controller;
use App\Pipelines\Advertisements\FilterAdvertisementsByTitle;
use App\Http\Requests\App\AdvertisementGridViewRequest;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Resources\App\AdvertisementResource;
use App\Models\Advertise\Advertisement;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class AdvertisementController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(AdvertisementGridViewRequest $request): AdvertisementCollection
    {
        $query = Advertisement::query();
        $filters = [
            FilterAdvertisementsByTitle::class,
        ];

        $advertisements = app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->then(fn(Builder $query) => $query->get());

        return new AdvertisementCollection($advertisements);
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
