<?php

declare(strict_types=1);

use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

test('users can authenticate using the login screen', function (): void {

    $response = \Pest\Laravel\post(route('login'), [
        'email'    => $this->user->email,
        'password' => 'password',
    ]);

    Pest\Laravel\assertAuthenticated();
    $response->assertNoContent();
});

test('users can not authenticate with invalid password', function (): void {

    \Pest\Laravel\post(route('login'), [
        'email'    => $this->user->email,
        'password' => 'wrong-password',
    ]);

    Pest\Laravel\assertGuest();
});

test('users can logout', function (): void {

    $response = asUser($this->user)->post(route('logout'));

    Pest\Laravel\assertGuest();
    $response->assertNoContent();
});
