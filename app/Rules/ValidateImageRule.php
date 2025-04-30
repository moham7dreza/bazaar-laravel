<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Exceptions\NotSupportedException;
use Intervention\Image\Laravel\Facades\Image;

class ValidateImageRule implements ValidationRule
{
    public function validate($attribute, $value, Closure $fail): void
    {
        if (! ($value instanceof UploadedFile)) {
            $fail(trans('validation.file', ['attribute' => $attribute]));

            return;
        }

        try {
            $image = Image::read($value->getRealPath());

            $originalWidth = $image->width();
            $originalHeight = $image->height();

            $maxAspectRatio = 2;
            $aspectRatio = $originalWidth / $originalHeight;

            //              Too Wide                           Too Tall
            if ($aspectRatio > $maxAspectRatio || $aspectRatio < (1 / $maxAspectRatio)) {
                $fail(trans('validation.image_aspect_ratio', ['attribute' => $attribute]));

                return;
            }
        } catch (NotSupportedException) {
            $fail(trans('validation.image', ['attribute' => $attribute]));
        }
    }
}
