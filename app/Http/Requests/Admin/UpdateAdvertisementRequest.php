<?php

namespace App\Http\Requests\Admin;

use App\Enums\Content\ImageSize;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdvertisementRequest extends FormRequest
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
            'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'description' => 'required|max:700|min:2',
            'ads_type' => 'nullable|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'ads_status' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,_ ]+$/u',
            'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:categories,id',
            'city_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:cities,id',
            'user_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:users,id',
            'status' => 'required|numeric|in:0,1',
            'published_at' => 'nullable|date',
            'expired_at' => 'nullable|date',
            'contact' => 'nullable|max:255|min:2',
            'is_special' => 'nullable|numeric|in:0,1',
            'image' => 'nullable|max:2000|image|mimes:png,jpg,jpeg,gif',
            'price' => 'nullable|numeric',
            'tags' => 'nullable',
            'lng' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
            'willing_to_trade' => 'nullable|numeric|in:0,1',
            'current_image_size' => Rule::enum(ImageSize::class),
        ];
    }
}
