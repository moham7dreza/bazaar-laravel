<?php

declare(strict_types=1);

namespace App\Services\Image;

use App\Enums\Content\ImageUploadMethod;
use App\Services\Image\Upload\CreateIndexAndSaveImageUploaderService;
use App\Services\Image\Upload\FitAndSaveImageUploaderService;
use App\Services\Image\Upload\ImageUploader;
use App\Services\Image\Upload\SimpleImageUploaderService;

final class ImageUploadFactory
{
    public static function make(ImageUploadMethod $uploadMethod): ?ImageUploader
    {
        $className = match ($uploadMethod)
        {
            ImageUploadMethod::METHOD_SAVE                  => SimpleImageUploaderService::class,
            ImageUploadMethod::METHOD_FIT_AND_SAVE          => FitAndSaveImageUploaderService::class,
            ImageUploadMethod::METHOD_CREATE_INDEX_AND_SAVE => CreateIndexAndSaveImageUploaderService::class,
        };

        return self::resolve($className);
    }

    private static function resolve(?string $className): ?ImageUploader
    {
        if (null === $className || ! class_exists($className))
        {
            return null;
        }

        return app($className);
    }
}
