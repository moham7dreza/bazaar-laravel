<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

it('can assign permissions to specific role', function () {

    $user = User::factory()->admin()->create([
        'email' => fake()->email,
        'mobile' => '09123324343',
    ]);

    $response = asAdminUser($user)->putJson(route('web.permissions.sync'), [
        'role' => $role = UserRole::ADMIN,
        'permissions' => [
            UserPermission::MANAGE_USERS,
        ],
    ]);

    $response->assertOk();

    $permissions = Role::firstWhere(['name' => $role])
        ->permissions()
        ->pluck('name')
        ->intersect(UserPermission::values())
        ->isNotEmpty();

    expect($permissions)->toBeTrue();
})
    ->skip();
