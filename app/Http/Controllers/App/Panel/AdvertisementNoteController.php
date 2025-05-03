<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiNewJsonResponse;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdvertisementNoteController extends Controller
{
    public function index(): ResourceCollection
    {
        return AdvertisementNote::all()->toResourceCollection(AdvertisementNoteCollection::class);
    }

    public function store(Advertisement $advertisement, Request $request)
    {
        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $note = AdvertisementNote::updateOrCreate(['user_id' => auth()->id(), 'advertisement_id' => $advertisement->id], ['note' => $request->note]);

        return ApiNewJsonResponse::success($note, message: 'یادداشت با موفقیت ذخیره شد');
    }

    public function show(Advertisement $advertisement)
    {
        $note = AdvertisementNote::where('user_id', auth()->id())->where('advertisement_id', $advertisement->id)->first();

        if (! $note) {
            return ApiNewJsonResponse::error(404, message: 'یادداشتی برای این آگهی پیدا نشد');
        }

        return ApiNewJsonResponse::success($note, message: 'یادداشت دریافت شد');
    }

    public function destroy(Advertisement $advertisement)
    {
        $note = AdvertisementNote::where('user_id', auth()->id())->where('advertisement_id', $advertisement->id)->first();

        if (! $note) {
            return ApiNewJsonResponse::error(404, message: 'یادداشتی برای این آگهی پیدا نشد');
        }

        $note->delete();

        return ApiNewJsonResponse::success(message: 'یادداشت حذف شد');
    }
}
