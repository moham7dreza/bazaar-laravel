<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Resources\App\AdvertisementResource;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Log;
use Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController;
use Modules\Advertise\Http\Requests\App\AdvertisementGridViewRequest;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Repositories\AdvertisementReadRepository;
use Throwable;

final class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(AdvertisementGridViewRequest $request): ResourceCollection
    {
        info('search log [{date}].', ['date' => now()->jdate()->format('Y-m-d H:i:s')]);

        $advertisements = app(AdvertisementReadRepository::class)->search($request->getDTO());

        return new AdvertisementCollection($advertisements->items);
//        return $advertisements->items->toResourceCollection(AdvertisementCollection::class);
    }

    public function show(Advertisement $advertisement): JsonResource|JsonResponse
    {
        info('pdp page log [{date}].', ['date' => now()->jdate()->format('Y-m-d H:i:s')]);

        if ($advertisement->trashed())
        {

            Log::error('missing advertisement access attempt', [
                'advertisement_id' => $advertisement->id,
            ]);

            return ApiJsonResponse::error(404, message: 'این آگهی حذف شده است');
        }

        Model::withoutTimestamps(static fn () => $advertisement->increment('view'));

        $historyController = new HistoryAdvertisementController();
        $historyController->store($advertisement);

        /*
        $advertisement->withRelationshipAutoloading();
        $advertisement->load([
            'category.parent', 'images', 'category.attributes', 'categoryValues',
        ]);
        */

        $advertisement->refresh();

        return $advertisement->toResource(AdvertisementResource::class);
    }
}
