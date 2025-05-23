<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Services\Image\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Requests\Admin\StoreAdvertisementRequest;
use Modules\Advertise\Http\Requests\Admin\UpdateAdvertisementRequest;
use Modules\Advertise\Http\Resources\Admin\AdvertisementResource;
use Modules\Advertise\Jobs\ProcessNewAdvertisementJob;
use Modules\Advertise\Models\Advertisement;

final class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return Advertisement::all()->toResourceCollection(AdvertisementResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result)
            {
                $inputs['image'] = $result;
            } else
            {
                return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
            }
        }

        $ad = Advertisement::create($inputs);

        ProcessNewAdvertisementJob::dispatch($ad->id);

        return $ad->toResource(AdvertisementResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement): JsonResource
    {
        return $advertisement->toResource(AdvertisementResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement, ImageService $imageService): JsonResource|JsonResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('image'))
        {
            if ( ! empty(($advertisement->image)))
            {
                $imageService->deleteDirectoryAndFiles($advertisement->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if (false === $result)
            {
                return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
            }
            $inputs['image'] = $result;
        } else
        {
            if (isset($inputs['currentImage']) && ! empty($advertisement->image))
            {
                $image                 = $advertisement->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image']       = $image;
            }
        }
        $advertisement->update($inputs);

        return $advertisement->toResource(AdvertisementResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement): JsonResponse
    {
        $advertisement->delete();

        return ApiJsonResponse::success(message: __('response.general.successful'));
    }
}
