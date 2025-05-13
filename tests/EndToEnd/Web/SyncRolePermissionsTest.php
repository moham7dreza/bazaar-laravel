<?php

declare(strict_types=1);

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    $this->user = User::factory()->admin()->create();
});

it('role is required when sync permissions', function (): void {

    asAdminUser($this->user)->putJson(route('web.permissions.sync'), [
        'permissions' => [
            UserPermission::MANAGE_USERS,
        ],
    ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['role'])
        ->assertJsonMissingValidationErrors(['permissions'])
        ->assertOnlyJsonValidationErrors(['role']);
});

it('can assign permissions to specific role', function (): void {

    Permission::findOrCreate($permission = UserPermission::MANAGE_USERS->value);

    asAdminUser($this->user)->putJson(route('web.permissions.sync'), [
        'role'        => $role = UserRole::ADMIN,
        'permissions' => [
            $permission,
        ],
    ])
        ->assertOk();

    $permissions = Role::firstWhere(['name' => $role])
        ?->permissions()
        ->pluck('name')
        ->intersect(UserPermission::values())
        ->isNotEmpty();

    expect($permissions)->toBeTrue();
});
