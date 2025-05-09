<?php

namespace App\Http\Requests\Admin;

use App\Enums\Content\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use App\Rules\ValidateImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGalleryRequest extends FormRequest
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
            'image'         => ['nullable', 'max:2000', 'image', 'mimes:png,jpg,jpeg,gif', new ValidateImageRule()],
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
            uploadMethod: $this->enum('upload_method', ImageUploadMethod::class),
            uploadDirectory: $this->get('directory'),
            width: $this->get('width'),
            height: $this->get('height'),
        );
    }
}
