<?php

namespace App\Http\Services\Image\Upload;

use App\Http\DataContracts\Image\ImageUploadDTO;
use App\Http\Services\Image\ImageService;
use App\Utilities\Date\TimeUtility;
use Intervention\Image\Laravel\Facades\Image;

readonly class CreateIndexAndSaveImageUploaderService implements ImageUploader
{
    public function __construct(
        private ImageService $imageService,
    ) {
    }

    public function handle(ImageUploadDTO $DTO): array|string|null
    {
        try {
            $imageSizes = config('image-index.index-image-sizes');

            $this->imageService->setImage($DTO->image);

            if (! $this->imageService->getImageDirectory()) {

                $this->imageService->setImageDirectory(
                    TimeUtility::jalaliCurrentYearNumber().DIRECTORY_SEPARATOR.
                    TimeUtility::jalaliCurrentMonthNumber().DIRECTORY_SEPARATOR.
                    TimeUtility::jalaliCurrentDayNumber()
                );
            }

            $this->imageService->setImageDirectory($this->imageService->getImageDirectory().DIRECTORY_SEPARATOR.time());

            if (! $this->imageService->getImageName()) {

                $this->imageService->setImageName(TimeUtility::jalaliCurrentTimeAsFileName());
            }

            $imageName = $this->imageService->getImageName();

            $indexArray = [];
            foreach ($imageSizes as $sizeAlias => $imageSize) {
                $currentImageName = $imageName.'_'.$sizeAlias;
                $this->imageService->setImageName($currentImageName);
                $this->imageService->provider();

                Image::read($DTO->image->getRealPath())
                    ->resizeDown($imageSize['width'], $imageSize['height'])
                    ->save(public_path($this->imageService->getImageAddress()), null, $this->imageService->getImageFormat());

                $indexArray[$sizeAlias] = $this->imageService->getImageAddress();
            }

            $images['indexArray']   = $indexArray;
            $images['directory']    = $this->imageService->getFinalImageDirectory();
            $images['currentImage'] = config('image-index.default-current-index-image');

            return $images;

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return null;
        }
    }
}
