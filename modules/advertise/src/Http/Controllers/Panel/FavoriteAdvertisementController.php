<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Resources\App\AdvertisementResource;
use Modules\Advertise\Models\Advertisement;
use Throwable;

final class FavoriteAdvertisementController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        $favorites = getUser()
            ?->favoriteAdvertisements()
            ->with('category', 'city')
            ->paginate(10);

        return $favorites->toResourceCollection(AdvertisementResource::class);
    }

    /**
     * @throws Throwable
     */
    public function store(Advertisement $advertisement): JsonResource|JsonResponse
    {

        $user = getUser();

        if ($user?->favoriteAdvertisements()->whereBelongsTo($advertisement)->exists())
        {
            return ApiJsonResponse::error(400, 'این آگهی قبلا نشان شده است');
        }

        $user?->favoriteAdvertisements()->attach($advertisement->id);

        return $advertisement->toResource(AdvertisementResource::class);
    }

    public function destroy(Advertisement $advertisement): JsonResponse
    {
        $user = getUser();

        if ( ! $user?->favoriteAdvertisements()->whereBelongsTo($advertisement)->exists())
        {
            return ApiJsonResponse::error(400, 'این آگهی در لیست نشان شده ها نیست');
        }

        $user?->favoriteAdvertisements()->detach($advertisement->id);

        return ApiJsonResponse::success(message: 'آگهی با موفقیت از نشان شده ها حذف شد');
    }
}
