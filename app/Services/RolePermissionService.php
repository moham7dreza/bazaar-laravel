<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserPermission as P;
use App\Enums\UserRole as R;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final readonly class RolePermissionService
{
    public function __construct(
        private PermissionRegistrar $permissionRegistrar,
    ) {
    }

    public function forgetCachedPermissions(): void
    {
        $this->permissionRegistrar->forgetCachedPermissions();
    }

    public function seedPermissions(): void
    {
        P::totalCases()
            ->each(static fn (P $permission) => Permission::query()->firstOrCreate(['name' => $permission]));
    }

    public function seedRoles(): void
    {
        R::totalCases()
            ->each(static fn (R $role) => Role::query()->firstOrCreate(['name' => $role]));
    }

    public function syncAdminRolePermissions(): void
    {
        R::Admin->model()
            ->syncPermissions(
                P::cases()
            );
    }

    public function assignAdminRole(User $user): void
    {
        $user->assignRole(
            R::Admin,
        );
    }

    public function assignAdminPermission(User $user): void
    {
        $user->givePermissionTo(
            P::SeePanel,
        );
    }
}
