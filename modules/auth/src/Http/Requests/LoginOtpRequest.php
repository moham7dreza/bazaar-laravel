<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class LoginOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile'    => 'required|numeric|digits:11|regex:/^09[0-9]{9}$/|unique:users',
        ];
    }
}
