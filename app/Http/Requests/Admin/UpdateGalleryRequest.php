<?php

namespace App\Http\Requests\Admin;

use App\Enums\Content\ImageSize;
use App\Enums\Content\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use App\Models\Advertise\Advertisement;
use App\Rules\ValidateImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'              => ['required', 'max:2000', 'image', 'mimes:png,jpg,jpeg,gif', new ValidateImageRule()],
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
            model:              Advertisement::class,
            currentImageSize:   $this->enum('current_image_size', ImageSize::class),
            width:              $this->get('width'),
            height:             $this->get('height'),
        );
    }
}
