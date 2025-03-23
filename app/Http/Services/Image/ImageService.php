<?php

namespace App\Http\Services\Image;

use App\Enums\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ImageService extends ImageToolsService
{
    public function execute(ImageUploadDTO $DTO): array|string|null
    {
        try {

            $this->setExclusiveDirectory(
                config('image.default-parent-upload-directory') . DIRECTORY_SEPARATOR . $DTO->uploadDirectory,
            );

            return match ($DTO->uploadMethod) {
                ImageUploadMethod::METHOD_SAVE => $this->save($DTO->image),
                ImageUploadMethod::METHOD_CREATE_INDEX_AND_SAVE => $this->createIndexAndSave($DTO->image),
                ImageUploadMethod::METHOD_FIT_AND_SAVE => $this->fitAndSave($DTO->image, $DTO->width, $DTO->height),
                default => null,
            };

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }

    public function save($image): string|null
    {
        try {
            $this->setImage($image);
            $this->provider();

            (new ImageManager(new Driver()))
                ->read($image->getRealPath())
                ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

            return $this->getImageAddress();

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }

    public function fitAndSave($image, $width, $height): string|null
    {
        try {
            $this->setImage($image);
            $this->provider();

            (new ImageManager(new Driver()))
                ->read($image->getRealPath())
                ->resizeDown($width, $height)
                ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

            return $this->getImageAddress();

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }

    public function createIndexAndSave($image): array|null
    {
        try {
            $imageSizes = config('image.index-image-sizes');

            $this->setImage($image);

                $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));

            $this->setImageDirectory($this->getImageDirectory() . DIRECTORY_SEPARATOR . time());

                $this->getImageName() ?? $this->setImageName(time());

            $imageName = $this->getImageName();

            $indexArray = [];
            foreach ($imageSizes as $sizeAlias => $imageSize) {
                $currentImageName = $imageName . '_' . $sizeAlias;
                $this->setImageName($currentImageName);
                $this->provider();

                (new ImageManager(new Driver()))
                    ->read($image->getRealPath())
                    ->resizeDown($imageSize['width'], $imageSize['height'])
                    ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

                $indexArray[$sizeAlias] = $this->getImageAddress();
            }

            $images['indexArray'] = $indexArray;
            $images['directory'] = $this->getFinalImageDirectory();
            $images['currentImage'] = config('image.default-current-index-image');

            return $images;

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }


    public function deleteImage($imagePath): bool
    {
        try {
            if (is_file($imagePath)) {
                unlink($imagePath);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }


    public function deleteIndex($images): bool
    {
        try {
            $directory = public_path($images['directory']);
            return $this->deleteDirectoryAndFiles($directory);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }


    public function deleteDirectoryAndFiles($directory): bool
    {
        try {
            if (!is_dir($directory)) {
                return false;
            }

            foreach (glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_MARK) as $file) {
                if (is_dir($file)) {
                    $this->deleteDirectoryAndFiles($file);
                } else {
                    unlink($file);
                }
            }
            return rmdir($directory);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }
}
