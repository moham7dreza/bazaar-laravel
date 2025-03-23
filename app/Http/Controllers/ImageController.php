<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Http\Requests\ImageUpdateRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\Image\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function index()
    {
        return view('image');
    }

    public function store(ImageStoreRequest $request, ImageService $imageService): JsonResponse|array|string
    {
        $result = $imageService->upload($request->getDTO());

        if (!$result) {
            return ApiJsonResponse::error(trans('response.image.upload failed'), code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    public function update(ImageUpdateRequest $request, ImageService $imageService)
    {
        $image = [
            'indexArray' => [
                'large' => 'test',
                'medium' => 'test',
                'small' => 'test',
            ],
            'directory' => 'images\test\1404\01\03\1742733700',
            'currentImage' => 'medium',
        ];
        $result = $imageService->update($request->getDTO(), $image);

        if (!$result) {
            return ApiJsonResponse::error(trans('response.image.upload failed'));
        }

        return $result;
    }
}
