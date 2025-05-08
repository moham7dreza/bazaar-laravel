<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Advertise\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteAdvertisementController extends Controller
{
    /**
     * @throws \Throwable
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
     * @throws \Throwable
     */
    public function store(Advertisement $advertisement): JsonResource|JsonResponse
    {

        $user = getUser();

        if ($user?->favoriteAdvertisements()->whereBelongsTo($advertisement)->exists()) {
            return ApiJsonResponse::error(400, 'این آگهی قبلا نشان شده است');
        }

        $user?->favoriteAdvertisements()->attach($advertisement->id);

        return $advertisement->toResource(AdvertisementResource::class);
    }

    public function destroy(Advertisement $advertisement): JsonResponse
    {
        $user = getUser();

        if (! $user?->favoriteAdvertisements()->whereBelongsTo($advertisement)->exists()) {
            return ApiJsonResponse::error(400, 'این آگهی در لیست نشان شده ها نیست');
        }

        $user?->favoriteAdvertisements()->detach($advertisement->id);

        return ApiJsonResponse::success(message: 'آگهی با موفقیت از نشان شده ها حذف شد');
    }
}
