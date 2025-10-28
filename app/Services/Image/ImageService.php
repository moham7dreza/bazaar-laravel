<?php

declare(strict_types=1);

namespace App\Services\Image;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Enums\Image\ImageUploadMethod;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Morilog\Jalali\CalendarUtils;

final class ImageService extends ImageToolsService
{
    public function upload(ImageUploadDTO $DTO): array|string|null
    {
        try
        {
            $this->setExclusiveDirectory(
                config('image-index.default-parent-upload-directory') . DIRECTORY_SEPARATOR . $DTO->uploadDirectory,
            );

            return ImageUploadFactory::make($DTO->uploadMethod)?->handle($DTO);

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function update(ImageUploadDTO $DTO, array|string|null $image): array|string|null
    {
        try
        {

            if (ImageUploadMethod::METHOD_CREATE_INDEX_AND_SAVE === $DTO->uploadMethod)
            {

                if ($DTO->currentImageSize && ! empty($image))
                {
                    \Illuminate\Support\Arr::set($image, 'currentImage', $DTO->currentImageSize);

                    return $image;
                }

                if ( ! empty($image))
                {
                    $this->deleteIndex($image);
                }
            } else
            {
                if ( ! empty($image))
                {
                    $this->deleteImage($image);
                }
            }

            $this->setExclusiveDirectory(
                config('image-index.default-parent-upload-directory') . DIRECTORY_SEPARATOR . $DTO->uploadDirectory,
            );

            return ImageUploadFactory::make($DTO->uploadMethod)?->handle($DTO);

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function createIndexAndSave($image): ?array
    {
        try
        {
            $imageSizes = config('image-index.index-image-sizes');

            $this->setImage($image);

            if ( ! $this->getImageDirectory())
            {

                $this->setImageDirectory(
                    CalendarUtils::strftime('Y') . DIRECTORY_SEPARATOR .
                    CalendarUtils::strftime('m') . DIRECTORY_SEPARATOR .
                    CalendarUtils::strftime('d')
                );
            }

            $this->setImageDirectory($this->getImageDirectory() . DIRECTORY_SEPARATOR . time());

            if ( ! $this->getImageName())
            {

                $this->setImageName(CalendarUtils::strftime('Y_m_d_H_i_s'));
            }

            $imageName = $this->getImageName();

            $indexArray = [];
            foreach ($imageSizes as $sizeAlias => $imageSize)
            {
                $currentImageName = $imageName . '_' . $sizeAlias;
                $this->setImageName($currentImageName);
                $this->provider();

                (new ImageManager(new Driver()))
                    ->read($image->getRealPath())
                    ->resizeDown(\Illuminate\Support\Arr::get($imageSize, 'width'), \Illuminate\Support\Arr::get($imageSize, 'height'))
                    ->save(public_path($this->getImageAddress()), null, $this->getImageFormat());

                $indexArray[$sizeAlias] = $this->getImageAddress();
            }

            \Illuminate\Support\Arr::set($images, 'indexArray', $indexArray);
            \Illuminate\Support\Arr::set($images, 'directory', $this->getFinalImageDirectory());
            \Illuminate\Support\Arr::set($images, 'currentImage', config('image-index.default-current-index-image'));

            return $images;

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function deleteImage($imagePath): bool
    {
        try
        {
            if (is_file($imagePath))
            {
                unlink($imagePath);
            }

            return true;
        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function deleteIndex($images): bool
    {
        try
        {
            $directory = public_path(\Illuminate\Support\Arr::get($images, 'directory'));

            return $this->deleteDirectoryAndFiles($directory);

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function deleteDirectoryAndFiles($directory): bool
    {
        try
        {
            if ( ! is_dir($directory))
            {
                return false;
            }

            foreach (glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_MARK) as $file)
            {
                if (is_dir($file))
                {
                    $this->deleteDirectoryAndFiles($file);
                } else
                {
                    unlink($file);
                }
            }

            return rmdir($directory);

        } catch (Exception $e)
        {
            Log::error($e->getMessage());

            return false;
        }
    }
}
