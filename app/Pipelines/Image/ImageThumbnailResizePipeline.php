<?php

namespace App\Pipelines\Image;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

final readonly class ImageThumbnailResizePipeline
{
    public function __invoke(UploadedFile $image, \Closure $next)
    {
        $image = Image::read($image);

        $ratio = $image->width() / $image->height();

        [$width, $height] = match (true) {
            $ratio < 1   => [400, null],
            $ratio === 1 => [400, 400],
            $ratio > 1   => [null, 300],
        };

        $image = $image->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })
            ->crop(400, 300);

        return $next($image);
    }
}
