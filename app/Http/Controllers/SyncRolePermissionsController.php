<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Http\Requests\SyncRolePermissionsRequest;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\JsonResponse;

final class SyncRolePermissionsController extends Controller
{
    public function __invoke(SyncRolePermissionsRequest $request): JsonResponse
    {
        // Convert strings to Permission enum instances
        $permissions = $request
            ->collect('permissions')
            ->mapInto(UserPermission::class);

        // Verify admin-level permissions
        $requiresAdminPrivileges = $permissions
            ->filter
            ->isAdminLevel()
            ->isNotEmpty();

        if ($requiresAdminPrivileges && ! $request->user()->isAdmin())
        {
            return ApiJsonResponse::error(422, 'Admin privileges required for selected permissions');
        }

        // Assign permissions to role
        $request->enum('role', UserRole::class)
            ->model()
            ->syncPermissions(
                $permissions->map->value->toArray()
            );

        return ApiJsonResponse::success(message: 'Permissions updated successfully');
    }
}
