<?php

declare(strict_types=1);

namespace Modules\Content\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreMenuRequest extends FormRequest
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
            'title'     => ['required', 'max:120', 'min:2', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u'],
            'url'       => ['required', 'max:255'],
            'position'  => ['required', 'max:120', 'min:2', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u'],
            'status'    => ['required', 'numeric', 'in:0,1'],
            'icon'      => ['nullable', 'min:2', 'max:120'],
            'parent_id' => ['nullable', 'min:1', 'max:100000000', 'regex:/^[0-9]+$/u', 'exists:menus,id'],
        ];
    }
}
