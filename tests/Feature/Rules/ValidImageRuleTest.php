<?php

declare(strict_types=1);

use App\Rules\ValidateImageRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

it('passes with a valid image and valid aspect ratio', function (): void {

    $file = UploadedFile::fake()->image('valid_image.jpg', 100, 100);

    $validator = Validator::make(
        ['image' => $file],
        ['image' => [new ValidateImageRule()]]
    );

    expect($validator->passes())->toBeTrue();
});
