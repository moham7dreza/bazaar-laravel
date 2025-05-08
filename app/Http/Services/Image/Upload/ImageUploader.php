<?php

namespace App\Http\Services\Image\Upload;

use App\Http\DataContracts\Image\ImageUploadDTO;

interface ImageUploader
{
    public function handle(ImageUploadDTO $DTO): string|array|null;
}
