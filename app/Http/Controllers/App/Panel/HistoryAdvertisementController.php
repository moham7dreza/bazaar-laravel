<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Advertise\Advertisement;
use App\Traits\HttpResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HistoryAdvertisementController extends Controller
{
    use AuthorizesRequests, HttpResponses;

    public function index()
    {
        $history = auth()->user()->viewedAdvertisements()->with('category', 'city')->latest('pivot_updated_at')->get();

        return $this->success(AdvertisementResource::collection($history), 'لیست تاریخچه بازدید دریافت شد');
    }

    public function store(Advertisement $advertisement): JsonResponse
    {
        if (! auth()->check()) {
            return ApiJsonResponse::error(trans('response.general.forbidden'), code: Response::HTTP_FORBIDDEN);
        }
        $user = auth()->user();

        if ($user?->viewedAdvertisements()->where('advertisement_id', $advertisement->id)->exists()) {
            $user?->viewedAdvertisements()->updateExistingPivot($advertisement->id, ['updated_at' => now()]);
        } else {
            $user?->viewedAdvertisements()->attach($advertisement->id);
        }

        return ApiJsonResponse::success('لیست تاریخچه بازدید بروز شد');
    }
}
