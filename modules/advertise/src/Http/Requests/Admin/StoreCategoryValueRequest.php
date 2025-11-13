<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreCategoryValueRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value'                 => ['required', 'max:255', 'min:2', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u'],
            'type'                  => ['required', 'numeric', 'in:0,1'],
            'status'                => ['required', 'numeric', 'in:0,1'],
            'category_attribute_id' => ['required', 'max:100000000', 'regex:/^[0-9]+$/u', 'exists:category_attributes,id'],
        ];
    }
}
