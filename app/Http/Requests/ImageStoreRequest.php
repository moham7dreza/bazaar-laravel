<?php

namespace App\Http\Requests;

use App\Http\Services\Image\ImageService;
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
            'image' => ['required', 'mimes:png,jpg,jpeg'],
            'directory' => ['required', 'string'],
            'upload_method' => ['required', Rule::in(ImageService::METHODS)],
            'width' => ['required_if:upload_method,fit', 'integer'],
            'height' => ['required_if:upload_method,fit', 'integer'],
        ];
    }
}
