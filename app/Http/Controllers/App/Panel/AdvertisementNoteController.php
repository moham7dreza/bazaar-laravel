<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AdvertisementNoteController extends Controller
{
    use HttpResponses;

    public function store(Advertisement $advertisement, Request $request)
    {

        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $note = AdvertisementNote::updateOrCreate(['user_id' => auth()->id(), 'advertisement_id' => $advertisement->id], ['note' => $request->note]);

        return $this->success($note, 'یادداشت با موفقیت ذخیره شد');
    }

    public function show(Advertisement $advertisement)
    {
        $note = AdvertisementNote::where('user_id', auth()->id())->where('advertisement_id', $advertisement->id)->first();

        if (! $note) {
            return $this->error(null, 'یادداشتی برای این آگهی پیدا نشد', 404);
        }

        return $this->success($note, 'یادداشت دریافت شد');
    }

    public function destroy(Advertisement $advertisement)
    {
        $note = AdvertisementNote::where('user_id', auth()->id())->where('advertisement_id', $advertisement->id)->first();

        if (! $note) {
            return $this->error(null, 'یادداشتی برای این آگهی پیدا نشد', 404);
        }

        $note->delete();

        return $this->success(null, 'یادداشت حذف شد');
    }
}
