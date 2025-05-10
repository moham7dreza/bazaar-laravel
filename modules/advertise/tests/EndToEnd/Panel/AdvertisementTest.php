<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Panel;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

function createUserWithRoleAndPermissions(UserRole $userRole): User
{
    collect(UserPermission::ads())->each(static fn (UserPermission $permission) => Permission::query()->firstOrCreate(['name' => $permission]));

    $role = Role::query()->firstOrCreate(['name' => $userRole]);

    $user = User::factory()->create();
    $user->assignRole($role);

    match ($userRole)
    {
        UserRole::WRITER => $role->givePermissionTo([UserPermission::CREATE_AD, UserPermission::EDIT_AD]),
        UserRole::EDITOR => $role->givePermissionTo(UserPermission::ads()),
        default          => null,
    };

    $user->load('roles.permissions');
    $user->refresh();

    return $user;
}

beforeEach(function (): void {

    Role::query()->firstOrCreate(['name' => UserRole::WRITER]);
    Role::query()->firstOrCreate(['name' => UserRole::EDITOR]);

    app(PermissionRegistrar::class)->forgetCachedPermissions();

});

test('writer can access to advertisements', function (): void {

    $writer = createUserWithRoleAndPermissions(UserRole::WRITER);

    asUser($writer)->getJson(route('panel.advertise.advertisement.index'))->assertOk();
});
