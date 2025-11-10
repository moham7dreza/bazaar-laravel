<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class SyncRolePermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role'          => ['required', Rule::enum(UserRole::class)],
            'permissions'   => ['required', 'array'],
            'permissions.*' => ['required', Rule::enum(UserPermission::class)],
        ];
    }
}
