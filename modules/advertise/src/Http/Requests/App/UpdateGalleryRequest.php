<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateGalleryRequest extends FormRequest
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
            'url' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
