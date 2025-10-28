<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Services\Image\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Advertise\Http\Requests\App\StoreGalleryRequest;
use Modules\Advertise\Http\Requests\App\UpdateGalleryRequest;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Gallery;
use Throwable;

final class GalleryController extends Controller
{
    /**
     * @throws Throwable
     */
    public function index(Advertisement $advertisement): JsonResource
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $advertisement);

        return Gallery::query()
            ->whereBelongsTo($advertisement)
            ->paginate(10)
            ->toResourceCollection();
    }

    /**
     * @throws Throwable
     */
    public function store(StoreGalleryRequest $request, ImageService $imageService, Advertisement $advertisement): JsonResource|JsonResponse
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $advertisement);

        $inputs                     = $request->all();
        \Illuminate\Support\Arr::set($inputs, 'advertisement_id', $advertisement->id);

        if ($request->hasFile('url'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result)
            {
                \Illuminate\Support\Arr::set($inputs, 'url', $result);
            } else
            {
                return ApiJsonResponse::error(500, message: 'خطا در اپلود تصویر');
            }
        }

        return Gallery::query()->create($inputs)->toResource();
    }

    /**
     * @throws Throwable
     */
    public function show(Gallery $gallery): JsonResource
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $gallery->advertisement);

        return $gallery->toResource();
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery, ImageService $imageService)
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $gallery->advertisement);

        $inputs = $request->all();
        if ($request->hasFile('url'))
        {
            if ( ! empty(($gallery->url)))
            {
                $imageService->deleteDirectoryAndFiles(\Illuminate\Support\Arr::get($gallery->url, 'directory'));
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if (false === $result)
            {
                return ApiJsonResponse::error(500, message: 'خطا در فرایند اپلود');
            }
            \Illuminate\Support\Arr::set($inputs, 'url', $result);
        } else
        {
            if (null !== \Illuminate\Support\Arr::get($inputs, 'currentImage') && ! empty($gallery->url))
            {
                $image                 = $gallery->url;
                \Illuminate\Support\Arr::get($image, 'currentImage', \Illuminate\Support\Arr::get($inputs, 'currentImage'));
                \Illuminate\Support\Arr::set($inputs, 'url', $image);
            }
        }

        $gallery->update($inputs);

        return $gallery->toResource();
    }

    public function destroy(Gallery $gallery): JsonResponse
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $gallery->advertisement);

        $gallery->delete();

        return ApiJsonResponse::success(message: 'گالری حذف شد');
    }
}
