<?php

declare(strict_types=1);

namespace App\Services\Image;

use App\Helpers\TimeUtility;

class ImageToolsService
{
    private $image;

    private $exclusiveDirectory;

    private $imageDirectory;

    private $imageName;

    private $imageFormat;

    private $finalImageDirectory;

    private $finalImageName;

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }

    public function setExclusiveDirectory($exclusiveDirectory): void
    {
        $this->exclusiveDirectory = mb_trim($exclusiveDirectory, '/\\');
    }

    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    public function setImageDirectory($imageDirectory): void
    {
        $this->imageDirectory = mb_trim($imageDirectory, '/\\');
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageName($imageName): void
    {
        $this->imageName = $imageName;
    }

    public function setCurrentImageName(): void
    {
        if (filled($this->image))
        {

            $this->setImageName(pathinfo((string) $this->image->getClientOriginalName(), PATHINFO_FILENAME));
        }
    }

    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    public function setImageFormat($imageFormat): void
    {
        $this->imageFormat = $imageFormat;
    }

    public function getFinalImageDirectory()
    {
        return $this->finalImageDirectory;
    }

    public function setFinalImageDirectory($finalImageDirectory): void
    {
        $this->finalImageDirectory = $finalImageDirectory;
    }

    public function getFinalImageName()
    {
        return $this->finalImageName;
    }

    public function setFinalImageName($finalImageName): void
    {
        $this->finalImageName = $finalImageName;
    }

    public function getImageAddress(): string
    {
        return $this->finalImageDirectory . DIRECTORY_SEPARATOR . $this->finalImageName;
    }

    public function provider(): void
    {
        // set properties
        if ( ! $this->imageDirectory)
        {
            $this->setImageDirectory(
                TimeUtility::jalaliCurrentYearNumber() . DIRECTORY_SEPARATOR .
                TimeUtility::jalaliCurrentMonthNumber() . DIRECTORY_SEPARATOR .
                TimeUtility::jalaliCurrentDayNumber()
            );
        }

        if ( ! $this->imageName)
        {
            $this->setImageName(TimeUtility::jalaliCurrentTimeAsFileName());
        }

        if ( ! $this->imageFormat)
        {
            $this->setImageFormat($this->image->extension());
        }

        // set final image Directory
        $finalImageDirectory = blank($this->exclusiveDirectory)
            ? $this->imageDirectory
            : $this->exclusiveDirectory . DIRECTORY_SEPARATOR . $this->imageDirectory;

        $this->setFinalImageDirectory(public_path($finalImageDirectory));
        logger('image provider', [
            $this->image,
            $this->exclusiveDirectory,
            $this->imageDirectory,
            $this->imageName,
            $this->imageFormat,
            $this->finalImageDirectory,
        ]);
        // set final image name
        $this->setFinalImageName($this->imageName . '.' . $this->imageFormat);

        $this->checkDirectory($this->finalImageDirectory);
    }

    private function checkDirectory($imageDirectory): void
    {
        if ( ! file_exists($imageDirectory))
        {
            mkdir($imageDirectory, 0777, true);
        }
    }
}
