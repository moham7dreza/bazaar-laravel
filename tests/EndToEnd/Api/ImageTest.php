<?php

use Illuminate\Http\UploadedFile;
use App\Enums\ImageUploadMethod;

it('can upload an image', function () {
    $file = UploadedFile::fake()->image('test.jpg', 100, 100);

    $payload = [
        'image' => $file,
        'directory' => '/uploads',
        'upload_method' => ImageUploadMethod::METHOD_FIT_AND_SAVE->value,
        'width' => 100,
        'height' => 100,
    ];

    $response = $this->postJson(route('images.store'), $payload);
    $response->assertOk();
    expect($response->json())->not->toBeEmpty();
})
    ->skip();

it('fails to upload without image', function () {
    $payload = [
        'directory' => 'test-images',
        'upload_method' => ImageUploadMethod::METHOD_FIT_AND_SAVE->value,
        'width' => 100,
        'height' => 100,
    ];
    $response = $this->postJson(route('images.store'), $payload);
    $response->assertUnprocessable();
});
