<?php

declare(strict_types=1);

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

it('role is required when sync permissions', function (): void {

    asAdminUser($this->user)->putJson(route('web.permissions.sync'), [
        'permissions' => [
            UserPermission::ManageUsers,
        ],
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['role'])
        ->assertJsonMissingValidationErrors(['permissions'])
        ->assertOnlyJsonValidationErrors(['role']);
});

it('can assign permissions to specific role', function (): void {
    asAdminUser($this->user)->putJson(route('web.permissions.sync'), [
        'role'        => $role = UserRole::Admin,
        'permissions' => [
            UserPermission::ManageUsers,
        ],
    ])
        ->assertOk();

    $permissions = $role->model()
        ->getPermissionNames()
        ->intersect(UserPermission::values())
        ->isNotEmpty();

    expect($permissions)->toBeTrue();
});
