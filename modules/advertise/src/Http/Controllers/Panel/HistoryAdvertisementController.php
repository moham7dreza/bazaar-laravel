<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Date;
use Modules\Advertise\Models\Advertisement;
use Throwable;

final class HistoryAdvertisementController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return getUser()
            ?->viewedAdvertisements()
            ->with('category', 'city')
            ->latest('pivot_updated_at')
            ->paginate(10)
            ->toResourceCollection();
    }

    public function store(Advertisement $advertisement): JsonResponse
    {
        $user = getUser();

        if ($user?->viewedAdvertisements()->whereBelongsTo($advertisement)->exists())
        {
            $user?->viewedAdvertisements()->updateExistingPivot($advertisement->id, ['updated_at' => Date::now()]);
        } else
        {
            $user?->viewedAdvertisements()->attach($advertisement->id);
        }

        return ApiJsonResponse::success(message: 'لیست تاریخچه بازدید بروز شد');
    }
}
