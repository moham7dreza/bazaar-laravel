<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Services\Image\ImageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Modules\Advertise\Enums\AdvertisementPublishStatus;
use Modules\Advertise\Http\Requests\Panel\StoreAdvertisementRequest;
use Modules\Advertise\Http\Requests\Panel\UpdateAdvertisementRequest;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementPrice;
use Modules\Advertise\Services\Price\AdvertisementPriceCreateService;
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
        Gate::authorize('viewAny', Advertisement::class);

        return Advertisement::query()
            ->forAuth()
            ->paginate(10)
            ->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(StoreAdvertisementRequest $request, ImageService $imageService, AdvertisementPriceCreateService $priceCreateService): JsonResource|JsonResponse
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
            'tags'             => $request->tags,
            'lng'              => $request->lng,
            'lat'              => $request->lat,
            'willing_to_trade' => $request->willing_to_trade ?: 0,
            'user_id'          => auth()->id(),
            'status'           => AdvertisementPublishStatus::Pending,
        ];
        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if ($result)
            {
                Arr::set($inputs, 'image', $result);
            } else
            {
                return ApiJsonResponse::error(500, message: 'خطا در اپلود عکس');
            }
        }

        $ad = Advertisement::query()->create($inputs);

        $request->whenFilled('category_values', function (string $input) use ($ad): void {
            $ad->categoryValues()->attach($input);
        });

        $request->whenFilled('price', fn (int $price): AdvertisementPrice => $priceCreateService->handle($ad, $price));

        return $ad->toResource();
    }

    /**
     * Display the specified resource.
     *
     * @throws Throwable
     */
    public function show(Advertisement $advertisement): JsonResource
    {
        Gate::authorize('view', $advertisement);

        return $advertisement->toResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement, ImageService $imageService, AdvertisementPriceCreateService $priceCreateService): JsonResource|JsonResponse
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
            'status'           => AdvertisementPublishStatus::Pending,
        ];

        if ($request->hasFile('image'))
        {
            if (filled($advertisement->image))
            {
                $imageService->deleteDirectoryAndFiles(Arr::get($advertisement->image, 'directory'));
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-advertisement-images');
            $result = $imageService->createIndexAndSave($request->image);
            if (false === $result)
            {
                return ApiJsonResponse::error(500, message: 'خطا در فرایند اپلود');
            }

            Arr::set($inputs, 'image', $result);
        } else
        {
            if (null !== Arr::get($inputs, 'currentImage') && filled($advertisement->image))
            {
                $image                 = $advertisement->image;
                Arr::set($image, 'currentImage', Arr::get($inputs, 'currentImage'));
                Arr::set($inputs, 'image', $image);
            }
        }

        $advertisement->update($inputs);

        $request->whenFilled('category_values', function (string $input) use ($advertisement): void {
            $advertisement->categoryValues()->sync($input);
        });

        $request->whenFilled('price', fn (int $price): AdvertisementPrice => $priceCreateService->handle($advertisement, $price));

        return $advertisement->toResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Advertisement $advertisement): JsonResponse
    {
        Gate::authorize('delete', $advertisement);

        $advertisement->delete();

        return ApiJsonResponse::success(message: 'آگهی حذف شد');
    }
}
