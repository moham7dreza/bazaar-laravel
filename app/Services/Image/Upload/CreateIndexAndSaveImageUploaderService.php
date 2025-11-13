<?php

declare(strict_types=1);

namespace App\Services\Image\Upload;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Helpers\TimeUtility;
use App\Services\Image\ImageService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Laravel\Facades\Image;

final readonly class CreateIndexAndSaveImageUploaderService implements ImageUploader
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

            $imageSizes = config('image-index.index-image-sizes');

            $this->imageService->setImage($DTO->image);

            if ( ! $this->imageService->getImageDirectory())
            {

                $this->imageService->setImageDirectory(
                    TimeUtility::jalaliCurrentYearNumber() . DIRECTORY_SEPARATOR .
                    TimeUtility::jalaliCurrentMonthNumber() . DIRECTORY_SEPARATOR .
                    TimeUtility::jalaliCurrentDayNumber()
                );
            }

            $this->imageService->setImageDirectory($this->imageService->getImageDirectory() . DIRECTORY_SEPARATOR . time());

            if ( ! $this->imageService->getImageName())
            {
                $this->imageService->setImageName(TimeUtility::jalaliCurrentTimeAsFileName());
            }

            $imageName = $this->imageService->getImageName();

            $indexArray = [];
            foreach ($imageSizes as $sizeAlias => $imageSize)
            {
                $currentImageName = $imageName . '_' . $sizeAlias;
                $this->imageService->setImageName($currentImageName);
                $this->imageService->provider();

                Image::read($DTO->image->getRealPath())
                    ->resizeDown(Arr::get($imageSize, 'width'), Arr::get($imageSize, 'height'))
                    ->save(public_path($this->imageService->getImageAddress()), $this->imageService->getImageFormat());

                $indexArray[$sizeAlias] = $this->imageService->getImageAddress();
            }

            Arr::set($images, 'indexArray', $indexArray);
            Arr::set($images, 'directory', $this->imageService->getFinalImageDirectory());
            Arr::set($images, 'currentImage', config('image-index.default-current-index-image'));

            return $images;

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return null;
        }
    }
}
