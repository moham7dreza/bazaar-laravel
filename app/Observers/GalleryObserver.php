<?php

namespace App\Observers;


use App\Http\Services\Image\ImageService;
use App\Models\Advertise\Gallery;

class GalleryObserver
{
    public function created(Gallery $gallery): void
    {
        //
    }

    public function updated(Gallery $gallery): void
    {
        //
    }

    public function deleted(Gallery $gallery): void
    {
        //
    }

    public function restored(Gallery $gallery): void
    {
        //
    }

    public function forceDeleted(Gallery $gallery): void
    {
        if (! app()->runningUnitTests() && ! empty($images = $gallery->url)) {

            app(ImageService::class)->deleteIndex($images);
        }
    }
}
