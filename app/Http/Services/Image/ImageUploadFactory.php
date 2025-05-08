<?php

namespace App\Http\Services\Image;

use App\Enums\Content\ImageUploadMethod;
use App\Http\Services\Image\Upload\CreateIndexAndSaveImageUploaderService;
use App\Http\Services\Image\Upload\FitAndSaveImageUploaderService;
use App\Http\Services\Image\Upload\ImageUploader;
use App\Http\Services\Image\Upload\SimpleImageUploaderService;

final class ImageUploadFactory
{
    public static function make(ImageUploadMethod $uploadMethod): ?ImageUploader
    {
        $className = match ($uploadMethod) {
            ImageUploadMethod::METHOD_SAVE                  => SimpleImageUploaderService::class,
            ImageUploadMethod::METHOD_FIT_AND_SAVE          => FitAndSaveImageUploaderService::class,
            ImageUploadMethod::METHOD_CREATE_INDEX_AND_SAVE => CreateIndexAndSaveImageUploaderService::class,
            default                                         => null,
        };

        return self::resolve($className);
    }

    private static function resolve(?string $className): ?ImageUploader
    {
        if ($className === null || ! class_exists($className)) {
            return null;
        }

        return app($className);
    }
}
