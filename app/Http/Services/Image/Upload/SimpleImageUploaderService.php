<?php

namespace App\Http\Services\Image\Upload;

use App\Http\DataContracts\Image\ImageUploadDTO;
use App\Http\Services\Image\ImageService;
use Intervention\Image\Laravel\Facades\Image;

class SimpleImageUploaderService implements ImageUploader
{
    public function __construct(
        private readonly ImageService $imageService,
    ) {}

    public function handle(ImageUploadDTO $DTO): array|string|null
    {
        try {
            $this->imageService->setImage($DTO->image);
            $this->imageService->provider();

            Image::read($DTO->image->getRealPath())
                ->save(public_path($this->imageService->getImageAddress()), null, $this->imageService->getImageFormat());

            return $this->imageService->getImageAddress();

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return null;
        }
    }
}
