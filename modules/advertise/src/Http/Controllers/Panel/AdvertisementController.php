<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Services\Image\ImageService;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Requests\App\StoreAdvertisementRequest;
use Modules\Advertise\Http\Resources\App\AdvertisementCollection;
use Modules\Advertise\Http\Resources\App\AdvertisementResource;
use Modules\Advertise\Models\Advertisement;
use Throwable;

final class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        // TODO fix policy and revert
//        Gate::authorize('viewAny', Advertisement::class);

        return getUser()
            ->advertisements()
            ->paginate(10)
            ->toResourceCollection(AdvertisementCollection::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(StoreAdvertisementRequest $request, ImageService $imageService): JsonResource|JsonResponse
    {
        Gate::authorize('create', Advertisement::class);

        $inputs = [
            'title'            => $request->title,
            'description'      => $request->description,
            'ads_type'         => $request->ads_type,
            'ads_status'       => $request->ads_status,
            'category_id'      => $request->category_id,
            'city_id'          => $request->city_id,
            'contact'          => $request->contact,
            'image'            => $request->image,
            'price'            => $request->price,
            'tags'             => $request->tags,
            'lng'              => $request->lng,
            'lat'              => $request->lat,
            'willing_to_trade' => $request->willing_to_trade ?: 0,
            'user_id'          => auth()->user()->id,
            'status'           => 3,
        ];
        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result)
            {
                $inputs['image'] = $result;
            } else
            {
                return ApiJsonResponse::error(500, message: 'خطا در اپلود عکس');
            }
        }
        $ad = Advertisement::create($inputs);

        return $ad->toResource(AdvertisementResource::class);
    }

    /**
     * Display the specified resource.
     *
     * @throws Throwable
     */
    public function show(Advertisement $advertisement): JsonResource
    {
        Gate::authorize('view', $advertisement);

        return $advertisement->toResource(AdvertisementResource::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(Request $request, Advertisement $advertisement, ImageService $imageService): JsonResource|JsonResponse
    {
        Gate::authorize('update', $advertisement);

        $inputs = [
            'title'            => $request->title,
            'description'      => $request->description,
            'ads_type'         => $request->ads_type,
            'ads_status'       => $request->ads_status,
            'city_id'          => $request->city_id,
            'contact'          => $request->contact,
            'image'            => $request->image,
            'price'            => $request->price,
            'tags'             => $request->tags,
            'lng'              => $request->lng,
            'lat'              => $request->lat,
            'willing_to_trade' => $request->willing_to_trade ?: 0,
            'status'           => 3,
        ];

        if ($request->hasFile('image'))
        {
            if ( ! empty(($advertisement->image)))
            {
                $imageService->deleteDirectoryAndFiles($advertisement->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if (false === $result)
            {
                return ApiJsonResponse::error(500, message:  'خطا در فرایند اپلود');
            }
            $inputs['image'] = $result;
        } else
        {
            if (isset($inputs['currentImage']) && ! empty($advertisement->image))
            {
                $image                 = $advertisement->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image']       = $image;
            }
        }
        $advertisement->update($inputs);

        return $advertisement->toResource(AdvertisementResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement): JsonResponse
    {
        Gate::authorize('delete', $advertisement);

        $advertisement->delete();

        return ApiJsonResponse::success(message: 'آگهی حذف شد');
    }
}
