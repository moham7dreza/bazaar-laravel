<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreGalleryRequest;
use App\Http\Requests\App\UpdateGalleryRequest;
use App\Http\Resources\App\GalleryCollection;
use App\Http\Resources\App\GalleryResource;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\Image\ImageService;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\Gallery;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function index(Advertisement $advertisement): JsonResource
    {
        Gate::authorize('view', $advertisement);

        $galleries = Gallery::query()->whereBelongsTo($advertisement)->get();

        return $galleries->toResourceCollection(GalleryCollection::class);
    }

    /**
     * @throws \Throwable
     */
    public function store(StoreGalleryRequest $request, ImageService $imageService, Advertisement $advertisement): JsonResource|JsonResponse
    {
        Gate::authorize('view', $advertisement);

        $inputs                     = $request->all();
        $inputs['advertisement_id'] = $advertisement->id;

        if ($request->hasFile('url')) {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result) {
                $inputs['url'] = $result;
            } else {
                return ApiJsonResponse::error(500, message: 'خطا در اپلود تصویر');
            }
        }

        $gallery = Gallery::create($inputs);

        return $gallery->toResource(GalleryResource::class);
    }

    /**
     * @throws \Throwable
     */
    public function show(Gallery $gallery): JsonResource
    {
        Gate::authorize('view', $gallery->advertisement);

        return $gallery->toResource(GalleryResource::class);
    }

    /**
     * @throws \Throwable
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery, ImageService $imageService)
    {
        Gate::authorize('view', $gallery->advertisement);

        $inputs = $request->all();
        if ($request->hasFile('url')) {
            if (! empty(($gallery->url))) {
                $imageService->deleteDirectoryAndFiles($gallery->url['directory']);
            }
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result === false) {
                return ApiJsonResponse::error(500, message: 'خطا در فرایند اپلود');
            }
            $inputs['url'] = $result;
        } else {
            if (isset($inputs['currentImage']) && ! empty($gallery->url)) {
                $image                 = $gallery->url;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['url']         = $image;
            }
        }

        $gallery->update($inputs);

        return $gallery->toResource(GalleryResource::class);
    }

    public function destroy(Gallery $gallery): JsonResponse
    {
        Gate::authorize('view', $gallery->advertisement);

        $gallery->delete();

        return ApiJsonResponse::success(message: 'گالری حذف شد');
    }
}
