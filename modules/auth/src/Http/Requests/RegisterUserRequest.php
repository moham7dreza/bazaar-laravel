<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return[
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->withoutTrashed()],
            'password' => ['required', 'confirmed', Password::defaults()],
            'mobile'   => ['required', 'string', 'max:15', Rule::unique('users', 'mobile')->withoutTrashed()],
            'city_id'  => ['nullable', Rule::exists('cities', 'id')->whereNull('deleted_at')],
        ];
    }
}
