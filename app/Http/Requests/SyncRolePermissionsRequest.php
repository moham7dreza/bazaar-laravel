<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class SyncRolePermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role'          => ['required', new Enum(UserRole::class)],
            'permissions'   => ['required', 'array'],
            'permissions.*' => ['required', new Enum(UserPermission::class)],
        ];
    }
}
