<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

final class StoreCategoryAttributeRequest extends FormRequest
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
            'name'        => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'unit'        => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'type'        => 'required|numeric|in:0,1',
            'status'      => 'required|numeric|in:0,1',
            'category_id' => 'required|max:100000000|regex:/^[0-9]+$/u|exists:categories,id',
        ];
    }
}
