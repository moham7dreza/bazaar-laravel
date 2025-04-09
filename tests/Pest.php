<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

pest()->extend(Tests\TestCase::class)
    ->use(DatabaseTransactions::class)
    ->in('Feature', 'EndToEnd', '../modules/*/tests');

function asUser(User $user): \Tests\TestCase
{
    return test()->be($user);
}

function asAnAuthenticatedUser(): \Tests\TestCase
{
    $user = User::factory()->create();

    return asUser($user);
}

function asAdminUser(User $user): \Tests\TestCase
{
    $user->assignRole(UserRole::ADMIN);

    return test()->be($user);
}
