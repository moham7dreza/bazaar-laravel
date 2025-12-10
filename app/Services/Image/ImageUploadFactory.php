<?php

declare(strict_types=1);

namespace App\Services\Image;

use App\Enums\Image\ImageUploadMethod;
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
            ImageUploadMethod::MethodSave                  => SimpleImageUploaderService::class,
            ImageUploadMethod::MethodFitAndSave            => FitAndSaveImageUploaderService::class,
            ImageUploadMethod::MethodCreateIndexAndSave    => CreateIndexAndSaveImageUploaderService::class,
        };

        return self::resolve($className);
    }

    private static function resolve(?string $className): ?ImageUploader
    {
        if (null === $className || ! class_exists($className))
        {
            return null;
        }

        return resolve($className);
    }
}
