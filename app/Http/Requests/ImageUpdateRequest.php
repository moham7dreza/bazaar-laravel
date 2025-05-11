<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Enums\Image\ImageSize;
use App\Enums\Image\ImageUploadMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ImageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // image
            'image'              => ['nullable', 'max:2000', 'image', 'mimes:png,jpg,jpeg,gif'],
            'current_image_size' => ['string', Rule::enum(ImageSize::class)],
            'directory'          => ['required', 'string'],
            'upload_method'      => ['required', Rule::enum(ImageUploadMethod::class)],
            'width'              => ['required_if:upload_method,fit', 'integer'],
            'height'             => ['required_if:upload_method,fit', 'integer'],
        ];
    }

    public function getDTO(): ImageUploadDTO
    {
        return new ImageUploadDTO(
            image:              $this->file('image'),
            uploadMethod:       $this->enum('upload_method', ImageUploadMethod::class),
            uploadDirectory:    $this->get('directory'),
            currentImageSize:   $this->enum('current_image_size', ImageSize::class),
            width:              $this->get('width'),
            height:             $this->get('height'),
        );
    }
}
