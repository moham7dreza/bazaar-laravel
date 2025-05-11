<?php

declare(strict_types=1);

namespace App\Services\Image\Upload;

use App\Http\DataContracts\Image\ImageUploadDTO;

interface ImageUploader
{
    public function handle(ImageUploadDTO $DTO): string|array|null;
}
