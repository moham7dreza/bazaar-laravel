<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Advertise\Advertisement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HistoryAdvertisementController extends Controller
{
    use AuthorizesRequests;

    public function index(): ResourceCollection
    {
        $history = auth()->user()
            ?->viewedAdvertisements()
            ->with('category', 'city')
            ->latest('pivot_updated_at')
            ->get();

        return $history->toResourceCollection(AdvertisementCollection::class);
    }

    public function store(Advertisement $advertisement): JsonResponse
    {
        if (! auth()->check()) {
            return ApiJsonResponse::error(403, __('response.general.forbidden'));
        }
        $user = auth()->user();

        if ($user?->viewedAdvertisements()->where('advertisement_id', $advertisement->id)->exists()) {
            $user?->viewedAdvertisements()->updateExistingPivot($advertisement->id, ['updated_at' => now()]);
        } else {
            $user?->viewedAdvertisements()->attach($advertisement->id);
        }

        return ApiJsonResponse::success(message: 'لیست تاریخچه بازدید بروز شد');
    }
}
