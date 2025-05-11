<?php

declare(strict_types=1);

namespace App\Services\Image\Upload;

use App\Data\DTOs\Image\ImageUploadDTO;

interface ImageUploader
{
    public function handle(ImageUploadDTO $DTO): string|array|null;
}
