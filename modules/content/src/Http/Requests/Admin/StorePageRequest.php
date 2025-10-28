<?php

declare(strict_types=1);

namespace Modules\Content\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

final class StorePageRequest extends FormRequest
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
            'title'  => ['nullable', 'max:120', 'min:2', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u'],
            'body'   => ['required', 'min:1', 'max:10000'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ];
    }
}
