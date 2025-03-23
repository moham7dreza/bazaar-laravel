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
        $imageService->setExclusiveDirectory(
            config('image.default-parent-upload-directory') . DIRECTORY_SEPARATOR . $request->str('directory')
        );

        $image = $request->file('image');

        $result = match ($request->str('upload_method')->value()) {
            ImageService::METHOD_SAVE => $imageService->save($image),
            ImageService::METHOD_CREATE_INDEX_AND_SAVE => $imageService->createIndexAndSave($image),
            ImageService::METHOD_FIT_AND_SAVE => $imageService->fitAndSave($image, $request->integer('width'), $request->integer('height')),
            default => null,
        };

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
