<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Resources\App\GalleryCollection;
use Modules\Advertise\Models\Advertisement;
use Throwable;

final class AdvertisementGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(Advertisement $advertisement): ResourceCollection
    {
        return $advertisement->images->toResourceCollection(GalleryCollection::class);
    }
}
