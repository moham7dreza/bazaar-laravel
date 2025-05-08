<?php

namespace App\Http\Services\Image\Upload;

use App\Http\DataContracts\Image\ImageUploadDTO;
use App\Http\Services\Image\ImageService;
use Intervention\Image\Laravel\Facades\Image;

readonly class FitAndSaveImageUploaderService implements ImageUploader
{
    public function __construct(
        private ImageService $imageService,
    ) {
    }

    public function handle(ImageUploadDTO $DTO): array|string|null
    {
        try {
            $this->imageService->setImage($DTO->image);
            $this->imageService->provider();

            Image::read($DTO->image->getRealPath())
                ->resizeDown($DTO->width, $DTO->height)
                ->save(public_path($this->imageService->getImageAddress()), null, $this->imageService->getImageFormat());

            return $this->imageService->getImageAddress();

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return null;
        }
    }
}
