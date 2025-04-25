<?php

namespace App\Http\Controllers\App\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreGalleryRequest;
use App\Http\Requests\App\UpdateGalleryRequest;
use App\Http\Resources\App\GalleryCollection;
use App\Http\Resources\App\GalleryResource;
use App\Http\Services\Image\ImageService;
use App\Models\Advertise\Gallery;
use App\Traits\HttpResponses;

class GalleryController extends Controller
{
    use HttpResponses;

    /**
     * نمایش لیست گالری‌های یک آگهی.
     */
    public function index($advertisementId)
    {
        // بررسی اینکه آگهی متعلق به کاربر است
        $advertisement = auth()->user()->advertisements()->find($advertisementId);
        if (! $advertisement) {
            return $this->error(null, 'آگهی مورد نظر یافت نشد یا متعلق به شما نیست', 403);
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
            return $this->error(null, 'آگهی مورد نظر یافت نشد یا متعلق به شما نیست', 403);
        }

        $inputs = $request->all();
        $inputs['advertisement_id'] = $advertisementId;

        if ($request->hasFile('url')) {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result) {
                $inputs['url'] = $result;
            } else {
                return $this->error(null, 'خطا در اپلود تصویر', 500);
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
            return $this->error(null, 'دسترسی غیرمجاز', 403);
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
            return $this->error(null, 'دسترسی غیرمجاز', 403);
        }

        $inputs = $request->all();
        if ($request->hasFile('url')) {
            if (! empty(($gallery->url))) {
                $imageService->deleteDirectoryAndFiles($gallery->url['directory']);
            }
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'user-advertisement-images-gallery');
            $result = $imageService->createIndexAndSave($request->url);
            if ($result === false) {
                return $this->error(null, 'خطا در فرایند اپلود', 500);
            }
            $inputs['url'] = $result;
        } else {
            if (isset($inputs['currentImage']) && ! empty($gallery->url)) {
                $image = $gallery->url;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['url'] = $image;
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
            return $this->error(null, 'دسترسی غیرمجاز', 403);
        }

        $gallery->delete();

        return $this->success(null, 'گالری حذف شد');
    }
}
