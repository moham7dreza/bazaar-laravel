<?php

namespace App\Http\Services\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ImageService extends ImageToolsService
{
    public const string METHOD_SAVE = 'save';
    public const string METHOD_CREATE_INDEX_AND_SAVE = 'index';
    public const string METHOD_FIT_AND_SAVE = 'fit';

    public const array METHODS = [
        self::METHOD_SAVE,
        self::METHOD_CREATE_INDEX_AND_SAVE,
        self::METHOD_FIT_AND_SAVE,
    ];

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
