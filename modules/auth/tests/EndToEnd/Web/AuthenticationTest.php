<?php

declare(strict_types=1);

use function Pest\Laravel\post;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

test('users can authenticate using the login screen', function (): void {

    $response = post(route('login'), [
        'email'    => $this->user->email,
        'password' => 'password',
    ]);

    assertAuthenticated();
    $response->assertNoContent();
});

test('users can not authenticate with invalid password', function (): void {

    post(route('login'), [
        'email'    => $this->user->email,
        'password' => 'wrong-password',
    ]);

    assertGuest();
});

test('users can logout', function (): void {

    $response = asUser($this->user)->post(route('logout'));

    assertGuest();
    $response->assertNoContent();
});
