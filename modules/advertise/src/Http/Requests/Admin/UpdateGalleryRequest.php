<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\Admin;

use App\Data\DTOs\Image\ImageUploadDTO;
use App\Enums\Image\ImageSize;
use App\Enums\Image\ImageUploadMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Advertise\Models\Advertisement;

final class UpdateGalleryRequest extends FormRequest
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
            image: $this->file('image'),
            uploadMethod: $this->enum('upload_method', ImageUploadMethod::class, ImageUploadMethod::MethodSave),
            uploadDirectory: $this->get('directory'),
            model: Advertisement::class,
            currentImageSize: $this->enum('current_image_size', ImageSize::class, ImageSize::Medium),
            width: $this->get('width'),
            height: $this->get('height'),
        );
    }
}
