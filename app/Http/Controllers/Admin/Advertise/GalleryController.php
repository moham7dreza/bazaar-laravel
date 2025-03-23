<?php

namespace App\Http\Controllers\Admin\Advertise;

use App\Http\Resources\Admin\Advertise\GalleryCollection;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\Image\ImageService;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Http\Resources\Admin\Advertise\GalleryResource;
use App\Models\Advertise\Gallery;

class GalleryController extends Controller
{
    use HttpResponses;
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

        if ($result = $imageService->execute($request->getDTO())) {
            $inputs['url'] = $result;
        } else {
            return ApiJsonResponse::error(trans('response.image.upload failed'));
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
        if ($request->hasFile('url')) {
            if (!empty(($gallery->url))) {
                $imageService->deleteDirectoryAndFiles($gallery->url['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result === false) {
                return $this->error(null, 'خطا در فرایند اپلود', 500);
            }
            $inputs['url'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($gallery->url)) {
                $image = $gallery->url;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['url'] = $image;
            }
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
        return $this->success(null, 'گالری حذف شد');
    }
}
