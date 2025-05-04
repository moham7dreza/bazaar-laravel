<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreGalleryRequest;
use App\Http\Requests\App\UpdateGalleryRequest;
use App\Http\Resources\App\GalleryCollection;
use App\Http\Resources\App\GalleryResource;
use App\Http\Responses\ApiNewJsonResponse;
use App\Http\Services\Image\ImageService;
use App\Models\Advertise\Gallery;

class GalleryController extends Controller
{
    /**
     * نمایش لیست گالری‌های یک آگهی.
     */
    public function index($advertisementId)
    {
        // بررسی اینکه آگهی متعلق به کاربر است
        $advertisement = auth()->user()?->advertisements()->find($advertisementId);
        if (! $advertisement) {
            return ApiNewJsonResponse::error(403, message: 'آگهی مورد نظر یافت نشد یا متعلق به شما نیست');
        }
        $galleries = Gallery::where('advertisement_id', $advertisementId)->get();

        return new GalleryCollection($galleries);
    }

    /**
     * افزودن تصویر به گالری.
     */
    public function store(StoreGalleryRequest $request, ImageService $imageService, $advertisementId)
    {
        // بررسی اینکه آگهی متعلق به کاربر است
        $advertisement = auth()->user()->advertisements()->find($advertisementId);
        if (! $advertisement) {
            return ApiNewJsonResponse::error(403, message: 'آگهی مورد نظر یافت نشد یا متعلق به شما نیست');
        }

        $inputs                     = $request->all();
        $inputs['advertisement_id'] = $advertisementId;

        if ($request->hasFile('url')) {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result) {
                $inputs['url'] = $result;
            } else {
                return ApiNewJsonResponse::error(500, message: 'خطا در اپلود تصویر');
            }
        }

        $gallery = Gallery::create($inputs);

        return new GalleryResource($gallery);
    }

    /**
     * مشاهده جزئیات یک تصویر گالری.
     */
    public function show(Gallery $gallery)
    {
        // بررسی اینکه گالری متعلق به آگهی کاربر است
        if ($gallery->advertisement->user_id !== auth()->id()) {
            return ApiNewJsonResponse::error(403, message: 'دسترسی غیرمجاز');
        }

        return new GalleryResource($gallery);
    }

    /**
     * بروزرسانی تصویر گالری.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery, ImageService $imageService)
    {
        // بررسی اینکه گالری متعلق به آگهی کاربر است
        if ($gallery->advertisement->user_id !== auth()->id()) {
            return ApiNewJsonResponse::error(403, 'دسترسی غیرمجاز');
        }

        $inputs = $request->all();
        if ($request->hasFile('url')) {
            if (! empty(($gallery->url))) {
                $imageService->deleteDirectoryAndFiles($gallery->url['directory']);
            }
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result === false) {
                return ApiNewJsonResponse::error(500, message: 'خطا در فرایند اپلود');
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

        return new GalleryResource($gallery);
    }

    /**
     * حذف تصویر گالری.
     */
    public function destroy(Gallery $gallery)
    {
        // بررسی اینکه گالری متعلق به آگهی کاربر است
        if ($gallery->advertisement->user_id !== auth()->id()) {
            return ApiNewJsonResponse::error(403, message: 'دسترسی غیرمجاز');
        }

        $gallery->delete();

        return ApiNewJsonResponse::success(message: 'گالری حذف شد');
    }
}
