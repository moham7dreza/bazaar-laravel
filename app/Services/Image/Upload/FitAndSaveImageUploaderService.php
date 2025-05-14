<?php

declare(strict_types=1);

namespace App\Services\Image\Upload;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Services\Image\ImageService;
use Exception;
use Intervention\Image\Laravel\Facades\Image;
use Log;

final readonly class FitAndSaveImageUploaderService implements ImageUploader
{
    public function __construct(
        private ImageService $imageService,
    ) {
    }

    public function handle(ImageUploadDTO $DTO): array|string|null
    {
        try
        {
            $this->imageService->setExclusiveDirectory(
                config('image-index.default-parent-upload-directory') . DIRECTORY_SEPARATOR . $DTO->uploadDirectory,
            );

            $this->imageService->setImage($DTO->image);
            $this->imageService->provider();

            Image::read($DTO->image->getRealPath())
                ->resizeDown($DTO->width, $DTO->height)
                ->save(public_path($this->imageService->getImageAddress()), $this->imageService->getImageFormat());

            return $this->imageService->getImageAddress();

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return null;
        }
    }
}
