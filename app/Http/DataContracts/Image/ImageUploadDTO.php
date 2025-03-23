<?php

namespace App\Http\DataContracts\Image;

use App\Enums\ImageSize;
use App\Enums\ImageUploadMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

final readonly class ImageUploadDTO
{
    public function __construct(
        public UploadedFile|File|null $image,
        public ImageUploadMethod $uploadMethod,
        public string $uploadDirectory,
        public Model|null $model = null,
        public ImageSize|null $currentImageSize = null,
        public int|null $width = null,
        public int|null $height = null,
    )
    {
        //
    }
}
