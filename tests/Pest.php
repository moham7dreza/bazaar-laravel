<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

pest()->extend(Tests\TestCase::class)
    ->use(DatabaseTransactions::class)
    ->in('Feature', 'EndToEnd', '../modules/*/tests');

function asUser(User $user): TestCase
{
    return test()->be($user);
}

function asAnAuthenticatedUser(): TestCase
{
    $user = User::factory()->create();

    return asUser($user);
}

function asAdminUser(User $user): TestCase
{
    Role::findOrCreate(UserRole::ADMIN->value);
    Permission::findOrCreate(UserPermission::SEE_PANEL->value);
    $user->assignRole(UserRole::ADMIN);

    return test()->be($user);
}
