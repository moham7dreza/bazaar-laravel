<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Enums\Image\ImageUploadMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ImageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'         => [
                'required',
                'image',
                'mimes:png,jpg,jpeg',
                Rule::dimensions()->ratioBetween(0.25, 2),
                'processable_image',
            ],
            'directory'     => ['required', 'string'],
            'upload_method' => ['required', Rule::enum(ImageUploadMethod::class)],
            'width'         => ['required_if:upload_method,fit', 'integer'],
            'height'        => ['required_if:upload_method,fit', 'integer'],
        ];
    }

    public function getDTO(): ImageUploadDTO
    {
        return new ImageUploadDTO(
            image: $this->file('image'),
            uploadMethod: $this->enum('upload_method', ImageUploadMethod::class, ImageUploadMethod::METHOD_SAVE),
            uploadDirectory: $this->str('directory')->value(),
            width: $this->integer('width', null),
            height: $this->integer('height', null),
        );
    }
}
