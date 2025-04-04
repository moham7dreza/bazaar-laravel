<?php

namespace App\Http\Services\Image;

use Morilog\Jalali\CalendarUtils;

class ImageToolsService
{
    protected $image;

    protected $exclusiveDirectory;

    protected $imageDirectory;

    protected $imageName;

    protected $imageFormat;

    protected $finalImageDirectory;

    protected $finalImageName;

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
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }

    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    public function setImageDirectory($imageDirectory): void
    {
        $this->imageDirectory = trim($imageDirectory, '/\\');
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageName($imageName): void
    {
        $this->imageName = $imageName;
    }

    public function setCurrentImageName(): ?false
    {
        return ! empty($this->image) ? $this->setImageName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME)) : false;
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

    protected function checkDirectory($imageDirectory): void
    {

        if (! file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0777, true);
        }
    }

    public function getImageAddress(): string
    {
        return $this->finalImageDirectory.DIRECTORY_SEPARATOR.$this->finalImageName;
    }

    protected function provider(): void
    {

        // set properties
        $this->getImageDirectory() ?? $this->setImageDirectory(
            CalendarUtils::strftime('Y').DIRECTORY_SEPARATOR.
            CalendarUtils::strftime('m').DIRECTORY_SEPARATOR.
            CalendarUtils::strftime('d')
        );

        $this->getImageName() ?? $this->setImageName(CalendarUtils::strftime('Y_m_d_H_i_s'));
        $this->getImageFormat() ?? $this->setImageFormat($this->image->extension());

        // set final image Directory
        $finalImageDirectory = empty($this->getExclusiveDirectory()) ? $this->getImageDirectory() : $this->getExclusiveDirectory().DIRECTORY_SEPARATOR.$this->getImageDirectory();
        $this->setFinalImageDirectory($finalImageDirectory);

        // set final image name
        $this->setFinalImageName($this->getImageName().'.'.$this->getImageFormat());

        $this->checkDirectory($this->getFinalImageDirectory());
    }
}
