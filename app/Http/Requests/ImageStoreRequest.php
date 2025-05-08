<?php

namespace App\Http\Requests;

use App\Enums\Content\ImageUploadMethod;
use App\Http\DataContracts\Image\ImageUploadDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'         => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'directory'     => ['required', 'string'],
            'upload_method' => ['required', Rule::enum(ImageUploadMethod::class)],
            'width'         => ['required_if:upload_method,fit', 'integer'],
            'height'        => ['required_if:upload_method,fit', 'integer'],
        ];
    }

    public function getDTO(): ImageUploadDTO
    {
        return new ImageUploadDTO(
            image:              $this->file('image'),
            uploadMethod:       $this->enum('upload_method', ImageUploadMethod::class),
            uploadDirectory:    $this->str('directory'),
            width:              $this->integer('width', null),
            height:             $this->integer('height', null),
        );
    }
}
