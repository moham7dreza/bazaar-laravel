<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Advertise\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HistoryAdvertisementController extends Controller
{
    public function index(): ResourceCollection
    {
        $history = getUser()
            ?->viewedAdvertisements()
            ->with('category', 'city')
            ->latest('pivot_updated_at')
            ->get();

        return $history->toResourceCollection(AdvertisementCollection::class);
    }

    public function store(Advertisement $advertisement): JsonResponse
    {
        $user = getUser();

        if ($user?->viewedAdvertisements()->whereBelongsTo($advertisement)->exists()) {
            $user?->viewedAdvertisements()->updateExistingPivot($advertisement->id, ['updated_at' => now()]);
        } else {
            $user?->viewedAdvertisements()->attach($advertisement->id);
        }

        return ApiJsonResponse::success(message: 'لیست تاریخچه بازدید بروز شد');
    }
}
