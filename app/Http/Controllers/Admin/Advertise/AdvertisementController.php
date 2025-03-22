<?php

namespace App\Http\Controllers\Admin\Advertise;

use App\Http\Requests\Admin\UpdateAdvertisementRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\Image\ImageService;
use App\Http\Controllers\Controller;
use App\Models\Advertise\Advertisement;
use App\Http\Requests\Admin\StoreAdvertisementRequest;
use App\Http\Resources\Admin\Advertise\AdvertisementResource;
use App\Http\Resources\Admin\Advertise\AdvertisementCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AdvertisementCollection
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
                return ApiJsonResponse::error(trans('response.image.upload failed'), code: Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return new AdvertisementResource(Advertisement::create($inputs));
    }


    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement): AdvertisementResource
    {
        return new AdvertisementResource($advertisement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement, ImageService $imageService): AdvertisementResource|JsonResource
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if (!empty(($advertisement->image))) {
                $imageService->deleteDirectoryAndFiles($advertisement->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result === false) {
                return ApiJsonResponse::error(trans('response.image.upload failed'), code: Response::HTTP_INTERNAL_SERVER_ERROR);
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
    public function destroy(Advertisement $advertisement): JsonResource
    {
        return ApiJsonResponse::success(trans('response.general.successful'), $advertisement->delete());
    }
}
