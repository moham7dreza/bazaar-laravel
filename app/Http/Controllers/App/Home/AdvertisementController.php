<?php

namespace App\Http\Controllers\App\Home;

use App\Enums\Advertisement\Sort;
use App\Http\Controllers\App\Panel\HistoryAdvertisementController;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\AdvertisementGridViewRequest;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Resources\App\AdvertisementResource;
use App\Models\Advertise\Advertisement;
use App\Pipelines\Advertisements\FilterAdvertisementsByTitle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdvertisementGridViewRequest $request): ResourceCollection
    {
        info('search log [{date}].', ['date' => now()->toJalali()]);

        $query   = Advertisement::query();
        $sort    = $request->enum('sort', Sort::class);
        $filters = [
            FilterAdvertisementsByTitle::class,
        ];

        /** @var Collection $advertisements */
        $advertisements = app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->then(function (Builder $query) use ($sort) {
                return $query
                    ->active()
                    ->published()
                    ->when($sort, fn (Builder $builder) => $builder->sortBy($sort))
                    ->get();
            });

        return $advertisements->toResourceCollection(AdvertisementCollection::class);
    }

    public function show(Advertisement $advertisement): JsonResource
    {
        info('pdp page log [{date}].', ['date' => now()->toJalali()]);

        $advertisement->increment('view');
        $historyController = new HistoryAdvertisementController;
        $historyController->store($advertisement);

        $advertisement->withRelationshipAutoloading();
        /*
        $advertisement->load([
            'category.parent', 'images', 'category.attributes', 'categoryValues',
        ]);
        */

        $advertisement->refresh();

        return $advertisement->toResource(AdvertisementResource::class);
    }
}
