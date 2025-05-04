<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreAdvertisementRequest;
use App\Http\Resources\App\AdvertisementCollection;
use App\Http\Resources\App\AdvertisementResource;
use App\Http\Responses\ApiNewJsonResponse;
use App\Http\Services\Image\ImageService;
use App\Models\Advertise\Advertisement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AdvertisementCollection(auth()->user()->advertisements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request, ImageService $imageService)
    {
        $inputs = [
            'title'            => $request->title,
            'description'      => $request->description,
            'ads_type'         => $request->ads_type,
            'ads_status'       => $request->ads_status,
            'category_id'      => $request->category_id,
            'city_id'          => $request->city_id,
            'contact'          => $request->contact,
            'image'            => $request->image,
            'price'            => $request->price,
            'tags'             => $request->tags,
            'lng'              => $request->lng,
            'lat'              => $request->lat,
            'willing_to_trade' => $request->willing_to_trade ?: 0,
            'user_id'          => auth()->user()->id,
            'status'           => 3,
        ];
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result) {
                $inputs['image'] = $result;
            } else {
                return ApiNewJsonResponse::error(500, message: 'خطا در اپلود عکس');
            }
        }
        $ads = Advertisement::create($inputs);

        return new AdvertisementResource($ads);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        $this->authorize('view', $advertisement);

        return new AdvertisementResource($advertisement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement, ImageService $imageService)
    {
        $this->authorize('update', $advertisement);

        $inputs = [
            'title'            => $request->title,
            'description'      => $request->description,
            'ads_type'         => $request->ads_type,
            'ads_status'       => $request->ads_status,
            'city_id'          => $request->city_id,
            'contact'          => $request->contact,
            'image'            => $request->image,
            'price'            => $request->price,
            'tags'             => $request->tags,
            'lng'              => $request->lng,
            'lat'              => $request->lat,
            'willing_to_trade' => $request->willing_to_trade ?: 0,
            'status'           => 3,
        ];

        if ($request->hasFile('image')) {
            if (! empty(($advertisement->image))) {
                $imageService->deleteDirectoryAndFiles($advertisement->image['directory']);
            }
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result === false) {
                return ApiNewJsonResponse::error(500, message:  'خطا در فرایند اپلود');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && ! empty($advertisement->image)) {
                $image                 = $advertisement->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image']       = $image;
            }
        }
        $advertisement->update($inputs);

        return new AdvertisementResource($advertisement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);

        $advertisement->delete();

        return ApiNewJsonResponse::success(message: 'آگهی حذف شد');
    }
}
