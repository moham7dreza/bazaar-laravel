<?php

use App\Rules\ValidateImageRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

it('passes with a valid image and valid aspect ratio', function () {

    $file = UploadedFile::fake()->image('valid_image.jpg', 100, 100);

    $validator = Validator::make(
        ['image' => $file],
        ['image' => [new ValidateImageRule()]]
    );

    expect($validator->passes())->toBeTrue();
});

it('passes with a valid image but invalid aspect ratio', function ($width, $height) {

    $file = UploadedFile::fake()->image('valid_image.jpg', $width, $height);

    $validator = Validator::make(
        ['image' => $file],
        ['image' => [new ValidateImageRule()]]
    );

    expect($validator->fails())->toBeTrue();

})->with([
    [10, 21],
    [21, 10],
]);
