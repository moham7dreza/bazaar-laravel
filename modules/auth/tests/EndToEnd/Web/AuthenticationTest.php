<?php

declare(strict_types=1);

use App\Models\User;

test('users can authenticate using the login screen', function (): void {
    $user = User::factory()->create();

    $response = \Pest\Laravel\post('/login', [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    Pest\Laravel\assertAuthenticated();
    $response->assertNoContent();
});

test('users can not authenticate with invalid password', function (): void {
    $user = User::factory()->create();

    \Pest\Laravel\post('/login', [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ]);

    Pest\Laravel\assertGuest();
});

test('users can logout', function (): void {
    $user = User::factory()->create();

    $response = asUser($user)->post('/logout');

    Pest\Laravel\assertGuest();
    $response->assertNoContent();
});
