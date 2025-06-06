<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\Admin;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Enums\Image\ImageUploadMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'advertisement_id' => ['required', 'min:1', 'max:100000000', 'regex:/^[0-9]+$/u', 'exists:advertisements,id'],
            // image
            'image'         => [
                'required',
                'max:2048',
                'image',
                'mimes:png,jpg,jpeg,gif',
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
            uploadDirectory: $this->get('directory'),
            width: $this->get('width'),
            height: $this->get('height'),
        );
    }
}
