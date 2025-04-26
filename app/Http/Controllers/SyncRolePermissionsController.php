<?php

namespace App\Http\Controllers;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Spatie\Permission\Models\Role;

class SyncRolePermissionsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'role' => [new Enum(UserRole::class)],
            'permissions' => ['array'],
            'permissions.*' => [new Enum(UserPermission::class)],
        ]);

        // Convert strings to Permission enum instances
        $permissions = $request
            ->collect('permissions')
            ->mapInto(UserPermission::class);

        // Verify admin-level permissions
        $requiresAdminPrivileges = $permissions
            ->filter(fn (UserPermission $permission) => $permission->isAdminLevel())
            ->isNotEmpty();

        if ($requiresAdminPrivileges && ! $request->user()->isAdmin()) {

            return ApiJsonResponse::error('Admin privileges required for selected permissions');
        }

        // Assign permissions to role
        $role = $request->enum('role', UserRole::class);
        Role::firstWhere(['name' => $role])->permissions()->sync(
            $permissions->map->value->toArray()
        );

        return ApiJsonResponse::success('Permissions updated successfully');
    }
}
