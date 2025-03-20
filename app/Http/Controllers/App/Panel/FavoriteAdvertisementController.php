<?php

namespace App\Http\Controllers\App\Panel;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\AdvertisementResource;
use App\Models\Advertise\Advertisement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FavoriteAdvertisementController extends Controller
{
    use HttpResponses, AuthorizesRequests;

    public function index()
    {
        $favorites = auth()->user()->favoriteAdvertisements()->with('category', 'city')->get();

        return $this->success(AdvertisementResource::collection($favorites), 'لیست آگهی های نشان شده شما دریافت شد');
    }


    public function store(Advertisement $advertisement)
    {

        $user = auth()->user();

        if ($user->favoriteAdvertisements()->where('advertisement_id', $advertisement->id)->exists()) {
            return $this->error(null, 'این آگهی قبلا نشان شده است', 400);
        }

        $user->favoriteAdvertisements()->attach($advertisement->id);

        return $this->success(new AdvertisementResource($advertisement), 'آگهی با موفقیت به نشان شده ها اضافه شد');
    }


    public function destroy(Advertisement $advertisement)
    {
        $user = auth()->user();


        if (!$user->favoriteAdvertisements()->where('advertisement_id', $advertisement->id)->exists()) {
            return $this->error(null, 'این آگهی در لیست نشان شده ها نیست', 400);
        }

        $user->favoriteAdvertisements()->detach($advertisement->id);


        return $this->success(null, 'آگهی با موفقیت از نشان شده ها حذف شد');
    }
}
