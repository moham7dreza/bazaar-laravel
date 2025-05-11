<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Http\Requests\ImageUpdateRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Services\Image\ImageService;
use Illuminate\Http\JsonResponse;

final class ImageController extends Controller
{
    public function index()
    {
        return view('image');
    }

    public function store(ImageStoreRequest $request, ImageService $imageService): JsonResponse|array|string
    {
        $result = $imageService->upload($request->getDTO());

        if ( ! $result)
        {
            return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
        }

        return $result;
    }

    public function update(ImageUpdateRequest $request, ImageService $imageService)
    {
        $image = [
            'indexArray' => [
                'large'  => 'test',
                'medium' => 'test',
                'small'  => 'test',
            ],
            'directory'    => 'images\test\1404\01\03\1742733700',
            'currentImage' => 'medium',
        ];
        $result = $imageService->update($request->getDTO(), $image);

        if ( ! $result)
        {
            return ApiJsonResponse::error(500, message: __('response.image.upload failed'));
        }

        return $result;
    }
}
