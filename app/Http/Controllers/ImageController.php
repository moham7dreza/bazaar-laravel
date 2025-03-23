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
        $result = $imageService->execute($request->getDTO());

        if (!$result) {
            return ApiJsonResponse::error(trans('response.image.upload failed'), code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    public function update(ImageUpdateRequest $request, ImageService $imageService)
    {
        //
    }
}
