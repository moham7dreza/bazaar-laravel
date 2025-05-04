<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Advertise\Advertisement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteAdvertisementController extends Controller
{
    use AuthorizesRequests;

    /**
     * @throws \Throwable
     */
    public function index(): ResourceCollection
    {
        $favorites = auth()->user()?->favoriteAdvertisements()->with('category', 'city')->get();

        return $favorites->toResourceCollection(AdvertisementResource::class);
    }

    public function store(Advertisement $advertisement): JsonResource|JsonResponse
    {

        $user = auth()->user();

        if ($user?->favoriteAdvertisements()->where('advertisement_id', $advertisement->id)->exists()) {
            return ApiJsonResponse::error(400, 'این آگهی قبلا نشان شده است');
        }

        $user?->favoriteAdvertisements()->attach($advertisement->id);

        return $advertisement->toResource(AdvertisementResource::class);
    }

    public function destroy(Advertisement $advertisement)
    {
        $user = auth()->user();

        if (! $user?->favoriteAdvertisements()->where('advertisement_id', $advertisement->id)->exists()) {
            return ApiJsonResponse::error(400, 'این آگهی در لیست نشان شده ها نیست');
        }

        $user?->favoriteAdvertisements()->detach($advertisement->id);

        return ApiJsonResponse::success(message: 'آگهی با موفقیت از نشان شده ها حذف شد');
    }
}
