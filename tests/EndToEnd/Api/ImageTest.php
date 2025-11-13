<?php

declare(strict_types=1);

use function Pest\Laravel\postJson;
use App\Enums\Image\ImageUploadMethod;
use Illuminate\Http\UploadedFile;

it('can upload an image', function (): void {
    $file = UploadedFile::fake()->image('test.jpg', 100, 100);

    $payload = [
        'image'         => $file,
        'directory'     => 'uploads',
        'upload_method' => ImageUploadMethod::MethodFitAndSave->value,
        'width'         => 100,
        'height'        => 100,
    ];

    $imagePath = postJson(route('api.images.store'), $payload)->assertOk()->content();

    expect(file_exists($imagePath))->toBeTrue();

    unlink($imagePath);
});

it('fails to upload without image', function (): void {
    $payload = [
        'directory'     => 'test-images',
        'upload_method' => ImageUploadMethod::MethodFitAndSave->value,
        'width'         => 100,
        'height'        => 100,
    ];
    $response = postJson(route('api.images.store'), $payload);
    $response->assertUnprocessable();
});
