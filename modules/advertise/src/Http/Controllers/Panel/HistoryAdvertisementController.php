<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Resources\App\AdvertisementCollection;
use Modules\Advertise\Models\Advertisement;
use Throwable;

final class HistoryAdvertisementController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        $history = getUser()
            ?->viewedAdvertisements()
            ->with('category', 'city')
            ->latest('pivot_updated_at')
            ->paginate(10);

        return $history->toResourceCollection(AdvertisementCollection::class);
    }

    public function store(Advertisement $advertisement): JsonResponse
    {
        $user = getUser();

        if ($user?->viewedAdvertisements()->whereBelongsTo($advertisement)->exists())
        {
            $user?->viewedAdvertisements()->updateExistingPivot($advertisement->id, ['updated_at' => now()]);
        } else
        {
            $user?->viewedAdvertisements()->attach($advertisement->id);
        }

        return ApiJsonResponse::success(message: 'لیست تاریخچه بازدید بروز شد');
    }
}
