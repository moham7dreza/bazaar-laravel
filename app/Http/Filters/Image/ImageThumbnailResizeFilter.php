<?php

declare(strict_types=1);

namespace App\Http\Filters\Image;

use Closure;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

class ImageThumbnailResizeFilter
{
    public function __invoke(UploadedFile $image, Closure $next)
    {
        $image = Image::read($image);

        $ratio = $image->width() / $image->height();

        [$width, $height] = match (true)
        {
            $ratio < 1   => [400, null],
            1 === $ratio => [400, 400],
            $ratio > 1   => [null, 300],
        };

        $image = $image->resize($width, $height)
            ->crop(400, 300);

        return $next($image);
    }
}
