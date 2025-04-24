<?php

namespace App\Http\Requests;

use App\Enums\Content\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageStoreRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg'],
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
            uploadMethod: ImageUploadMethod::from($this->get('upload_method')),
            uploadDirectory: $this->get('directory'),
            width: $this->get('width'),
            height: $this->get('height'),
        );
    }
}
