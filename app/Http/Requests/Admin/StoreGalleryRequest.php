<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'advertisement_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:advertisements,id',
            'url' => 'required|max:2000|image|mimes:png,jpg,jpeg,gif',
        ];
    }
}
