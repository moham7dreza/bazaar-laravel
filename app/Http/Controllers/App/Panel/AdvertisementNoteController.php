<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvertisementNoteController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = getUser()
            ->advertisementNotes()
            ->paginate(10);

        return ApiJsonResponse::success($notes);
    }

    public function store(Advertisement $advertisement, Request $request): JsonResponse
    {
        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $note = AdvertisementNote::query()
            ->updateOrCreate(
                [
                    'user_id'          => auth()->id(),
                    'advertisement_id' => $advertisement->id,
                ],
                [
                    'note' => $request->note,
                ]
            );

        return ApiJsonResponse::success($note, message: 'یادداشت با موفقیت ذخیره شد');
    }

    public function show(Advertisement $advertisement): JsonResponse
    {
        $note = AdvertisementNote::query()->firstWhere([
            'user_id'          => auth()->id(),
            'advertisement_id' => $advertisement->id,
        ]);

        if (! $note) {
            return ApiJsonResponse::error(404, message: 'یادداشتی برای این آگهی پیدا نشد');
        }

        return ApiJsonResponse::success($note, message: 'یادداشت دریافت شد');
    }

    public function destroy(Advertisement $advertisement): JsonResponse
    {
        $note = AdvertisementNote::query()->firstWhere([
            'user_id'          => auth()->id(),
            'advertisement_id' => $advertisement->id,
        ]);

        if (! $note) {
            return ApiJsonResponse::error(404, message: 'یادداشتی برای این آگهی پیدا نشد');
        }

        $note->delete();

        return ApiJsonResponse::success(message: 'یادداشت حذف شد');
    }
}
