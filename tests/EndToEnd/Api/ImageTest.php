<?php

declare(strict_types=1);

use App\Enums\Image\ImageUploadMethod;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

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

it('can update an image', function (): void {
    $file = UploadedFile::fake()->image('updated.jpg', 200, 200);

    $payload = [
        'image'         => $file,
        'directory'     => 'uploads',
        'upload_method' => ImageUploadMethod::MethodFitAndSave->value,
        'width'         => 200,
        'height'        => 200,
    ];

    $imagePath = putJson(route('api.images.destroy'), $payload)->assertOk()->content();

    expect(file_exists($imagePath))->toBeTrue();

    unlink($imagePath);
});

it('fails to update without image', function (): void {
    $payload = [
        'directory'     => 'test-images',
        'upload_method' => ImageUploadMethod::MethodFitAndSave->value,
        'width'         => 200,
        'height'        => 200,
    ];
    $response = putJson(route('api.images.destroy'), $payload);
    $response->assertUnprocessable();
});
