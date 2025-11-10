<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Models\Advertisement;
use Throwable;

final class FavoriteAdvertisementController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return auth()->user()
            ->favoriteAdvertisements()
            ->with('category', 'city')
            ->paginate(10)
            ->toResourceCollection();
    }

    /**
     * @throws Throwable
     */
    public function store(Advertisement $advertisement): JsonResource|JsonResponse
    {

        $user = auth()->user();

        if ($user->favoriteAdvertisements()->whereBelongsTo($advertisement)->exists())
        {
            return ApiJsonResponse::error(400, 'این آگهی قبلا نشان شده است');
        }

        $user->favoriteAdvertisements()->attach($advertisement->id);

        return $advertisement->toResource();
    }

    public function destroy(Advertisement $advertisement): JsonResponse
    {
        $user = auth()->user();

        if ( ! $user->favoriteAdvertisements()->whereBelongsTo($advertisement)->exists())
        {
            return ApiJsonResponse::error(400, 'این آگهی در لیست نشان شده ها نیست');
        }

        $user->favoriteAdvertisements()->detach($advertisement->id);

        return ApiJsonResponse::success(message: 'آگهی با موفقیت از نشان شده ها حذف شد');
    }
}
