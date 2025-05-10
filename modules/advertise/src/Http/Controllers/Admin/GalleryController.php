<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Http\Resources\Admin\Advertise\GalleryCollection;
use App\Http\Resources\Admin\Advertise\GalleryResource;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\Image\ImageService;
use Modules\Advertise\Models\Gallery;

final class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new GalleryCollection(Gallery::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($result = $imageService->upload($request->getDTO()))
        {
            $inputs['url'] = $result;
        } else
        {
            return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
        }
        $gallery = Gallery::create($inputs);

        return new GalleryResource($gallery);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return new GalleryResource($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($result = $imageService->update($request->getDTO(), $gallery->url))
        {
            $inputs['url'] = $result;
        } else
        {
            return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
        }
        $gallery->update($inputs);

        return new GalleryResource($gallery);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return ApiJsonResponse::success(message: 'گالری حذف شد');
    }
}
