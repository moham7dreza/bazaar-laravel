<?php

declare(strict_types=1);

namespace App\Data\DTOs\Image;

use App\Enums\Content\ImageSize;
use App\Enums\Content\ImageUploadMethod;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

final readonly class ImageUploadDTO
{
    public function __construct(
        public UploadedFile|File|null $image,
        public ImageUploadMethod $uploadMethod,
        public string $uploadDirectory,
        public ?string $model = null,
        public ?ImageSize $currentImageSize = null,
        public ?int $width = null,
        public ?int $height = null,
    ) {

    }
}
