<?php

namespace App\Http\Requests;

use App\Enums\Content\ImageSize;
use App\Enums\Content\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // image
            'image' => ['nullable', 'max:2000', 'image', 'mimes:png,jpg,jpeg,gif'],
            'current_image_size' => ['string', Rule::enum(ImageSize::class)],
            'directory' => ['required', 'string'],
            'upload_method' => ['required', Rule::enum(ImageUploadMethod::class)],
            'width' => ['required_if:upload_method,fit', 'integer'],
            'height' => ['required_if:upload_method,fit', 'integer'],
        ];
    }

    public function getDTO(): ImageUploadDTO
    {
        return new ImageUploadDTO(
            image: $this->file('image'),
            uploadMethod: ImageUploadMethod::tryFrom($this->get('upload_method')),
            uploadDirectory: $this->get('directory'),
            currentImageSize: ImageSize::tryFrom($this->get('current_image_size')),
            width: $this->get('width'),
            height: $this->get('height'),
        );
    }
}
