<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Services\Image\ImageService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Requests\Admin\StoreGalleryRequest;
use Modules\Advertise\Http\Requests\Admin\UpdateGalleryRequest;
use Modules\Advertise\Http\Resources\Admin\GalleryCollection;
use Modules\Advertise\Http\Resources\Admin\GalleryResource;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Gallery;
use Throwable;

final class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(Advertisement $advertisement): ResourceCollection
    {
        return $advertisement
            ->images
            ->toResourceCollection(GalleryCollection::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Advertisement $advertisement, StoreGalleryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($result = $imageService->upload($request->getDTO()))
        {
            Arr::set($inputs, 'url', $result);
        } else
        {
            return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
        }

        return Gallery::query()
            ->create($inputs)
            ->toResource(GalleryResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement, Gallery $gallery)
    {
        return $gallery->toResource(GalleryResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Advertisement $advertisement, UpdateGalleryRequest $request, Gallery $gallery, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($result = $imageService->update($request->getDTO(), $gallery->url))
        {
            Arr::set($inputs, 'url', $result);
        } else
        {
            return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
        }
        $gallery->update($inputs);

        return $gallery->toResource(GalleryResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement, Gallery $gallery)
    {
        $gallery->delete();

        return ApiJsonResponse::success(message: 'گالری حذف شد');
    }
}
