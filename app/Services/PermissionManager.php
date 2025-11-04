<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

final class PermissionManager
{
    public function findRevokedPermissions(array $previousPerms, array $currentPerms): Collection
    {
        return collect($previousPerms)
            ->diffKeys($currentPerms)
            ->map(fn ($granted, $permission) => [
                'permission'  => $permission,
                'was_granted' => $granted,
                'revoked_at'  => Date::now(),
            ]);
    }

    public function validateUserAccess(array $userPermissions, array $requiredAccess): array
    {
        $missingAccess = collect($requiredAccess)
            ->diffKeys($userPermissions)
            ->keys();

        return [
            'has_access'          => $missingAccess->isEmpty(),
            'missing_permissions' => $missingAccess->all(),
        ];
    }

    public function auditPermissionChanges(array $before, array $after): array
    {
        $added   = collect($after)->diffKeys($before);
        $removed = collect($before)->diffKeys($after);

        return [
            'permissions_added'   => $added->keys()->all(),
            'permissions_removed' => $removed->keys()->all(),
            'change_summary'      => [
                'additions' => $added->count(),
                'removals'  => $removed->count(),
            ],
        ];
    }
}
