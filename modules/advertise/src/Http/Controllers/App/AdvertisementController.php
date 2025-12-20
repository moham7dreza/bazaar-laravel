<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController;
use Modules\Advertise\Http\Requests\App\AdvertisementListViewRequest;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Repositories\Search\AdvertisementSearchRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

final class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(
        AdvertisementListViewRequest $request,
        AdvertisementSearchRepository $repository
    ): ResourceCollection {
        $searchDTO = $request->getDTO();

        return $repository
            ->search($searchDTO)
            ->paginate(
                perPage: $searchDTO->perPage,
                page: $searchDTO->page,
            )
            ->toResourceCollection();
    }

    public function show(Advertisement $advertisement): JsonResource|JsonResponse
    {
        info('pdp page log [{date}].', ['date' => Date::now()->toDateTimeString()]);

        if ($advertisement->trashed())
        {

            Log::error('missing advertisement access attempt', [
                'advertisement_id' => $advertisement->id,
            ]);

            return ApiJsonResponse::error(404, message: 'این آگهی حذف شده است');
        }

        Model::withoutTimestamps(static fn () => $advertisement->increment('view'));

        if (auth()->check())
        {
            // @todo:high: make service
            $historyController = new HistoryAdvertisementController();
            $historyController->store($advertisement);
        }

        /*
        $advertisement->withRelationshipAutoloading();
        $advertisement->load([
            'category.parent', 'images', 'category.attributes', 'categoryValues',
        ]);
        */

        $advertisement->refresh();

        return $advertisement->toResource();
    }

    /**
     * @throws Throwable
     */
    public function queryBuilder(): ResourceCollection
    {
        return QueryBuilder::for(Advertisement::class)
            ->allowedFilters(
                [
                    'title',
                    'description',
                    'tags',
                    // @todo:high: use relation
                    // AllowedFilter::operator('price', FilterOperator::GREATER_THAN_OR_EQUAL),
                ]
            )
            ->allowedSorts(
                [
                    'title',
                    // @todo:high: price is relation
                    // 'price',
                    'published_at',
                    'is_ladder',
                    'is_special',
                    'view',
                    'created_at',
                ]
            )
            ->allowedIncludes(
                [

                ]
            )
            ->paginate(12)
            ->toResourceCollection();
    }
}
