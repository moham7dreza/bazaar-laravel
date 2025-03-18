<?php

namespace App\Http\Controllers\Admin\Advertise;

use App\Http\Requests\Admin\UpdateAdvertisementRequest;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Models\Advertise\Advertisement;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\StoreAdvertisementRequest;
use App\Http\Resources\Admin\Advertise\AdvertisementResource;
use App\Http\Resources\Admin\Advertise\AdvertisementCollection;

class AdvertisementController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new AdvertisementCollection(Advertisement::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result) {
                $inputs['image'] = $result;
            } else {
                return $this->error(null, 'دسته بندی حذف شد', 500);
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
        return new AdvertisementResource($advertisement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if (!empty(($advertisement->image))) {
                $imageService->deleteDirectoryAndFiles($advertisement->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result === false) {
                return $this->error(null, 'خطا در فرایند اپلود', 500);
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($advertisement->image)) {
                $image = $advertisement->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
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
        $advertisement->delete();
        return $this->success(null, 'آگهی حذف شد');
    }
}
