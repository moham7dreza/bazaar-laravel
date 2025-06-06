<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Exceptions\NotSupportedException;
use Intervention\Image\Laravel\Facades\Image;

class ValidateImageRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( ! ($value instanceof UploadedFile))
        {
            $fail(trans('validation.file', ['attribute' => $attribute]));

            return;
        }

        try
        {
            $image = Image::read($value->getRealPath());
        } catch (NotSupportedException)
        {
            $fail(trans('validation.image', ['attribute' => $attribute]));
        }
    }
}
