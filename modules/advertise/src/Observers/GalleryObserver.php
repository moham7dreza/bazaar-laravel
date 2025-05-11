<?php

declare(strict_types=1);

namespace Modules\Advertise\Observers;

use App\Services\Image\ImageService;
use Modules\Advertise\Models\Gallery;

final class GalleryObserver
{
    public function created(Gallery $gallery): void
    {

    }

    public function updated(Gallery $gallery): void
    {

    }

    public function deleted(Gallery $gallery): void
    {

    }

    public function restored(Gallery $gallery): void
    {

    }

    public function forceDeleted(Gallery $gallery): void
    {
        if ( ! app()->runningUnitTests() && ! empty($images = $gallery->url))
        {

            app(ImageService::class)->deleteIndex($images);
        }
    }
}
