<?php

namespace App\Http\Services\Image;

use App\Enums\Content\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Morilog\Jalali\CalendarUtils;

class ImageService extends ImageToolsService
{
    public function upload(ImageUploadDTO $DTO): array|string|null
    {
        try {

            $this->setExclusiveDirectory(
                config('image-index.default-parent-upload-directory').DIRECTORY_SEPARATOR.$DTO->uploadDirectory,
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

    public function update(ImageUploadDTO $DTO, ?array $image): array|string|null
    {
        try {

            if ($DTO->uploadMethod === ImageUploadMethod::METHOD_CREATE_INDEX_AND_SAVE) {

                if ($DTO->currentImageSize && ! empty($image)) {
                    $image['currentImage'] = $DTO->currentImageSize;

                    return $image;
                }

                if (! empty($image)) {
                    $this->deleteIndex($image);
                }
            } else {
                if (! empty($image)) {
                    $this->deleteImage($image);
                }
            }

            $this->setExclusiveDirectory(
                config('image-index.default-parent-upload-directory').DIRECTORY_SEPARATOR.$DTO->uploadDirectory,
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

    public function save($image): ?string
    {
        try {
            $this->setImage($image);
            $this->provider();

            (new ImageManager(new Driver))
                ->read($image->getRealPath())
                ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

            return $this->getImageAddress();

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return null;
        }
    }

    public function fitAndSave($image, $width, $height): ?string
    {
        try {
            $this->setImage($image);
            $this->provider();

            (new ImageManager(new Driver))
                ->read($image->getRealPath())
                ->resizeDown($width, $height)
                ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

            return $this->getImageAddress();

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return null;
        }
    }

    public function createIndexAndSave($image): ?array
    {
        try {
            $imageSizes = config('image-index.index-image-sizes');

            $this->setImage($image);

            $this->getImageDirectory() ?? $this->setImageDirectory(
                CalendarUtils::strftime('Y').DIRECTORY_SEPARATOR.
                CalendarUtils::strftime('m').DIRECTORY_SEPARATOR.
                CalendarUtils::strftime('d')
            );

            $this->setImageDirectory($this->getImageDirectory().DIRECTORY_SEPARATOR.time());

            $this->getImageName() ?? $this->setImageName(CalendarUtils::strftime('Y_m_d_H_i_s'));

            $imageName = $this->getImageName();

            $indexArray = [];
            foreach ($imageSizes as $sizeAlias => $imageSize) {
                $currentImageName = $imageName.'_'.$sizeAlias;
                $this->setImageName($currentImageName);
                $this->provider();

                (new ImageManager(new Driver))
                    ->read($image->getRealPath())
                    ->resizeDown($imageSize['width'], $imageSize['height'])
                    ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

                $indexArray[$sizeAlias] = $this->getImageAddress();
            }

            $images['indexArray'] = $indexArray;
            $images['directory'] = $this->getFinalImageDirectory();
            $images['currentImage'] = config('image-index.default-current-index-image');

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
            if (! is_dir($directory)) {
                return false;
            }

            foreach (glob($directory.DIRECTORY_SEPARATOR.'*', GLOB_MARK) as $file) {
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
