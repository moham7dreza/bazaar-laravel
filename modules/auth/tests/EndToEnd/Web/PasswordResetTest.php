<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {})->skip('fix tests');

test('reset password link can be requested', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    \Pest\Laravel\post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('password can be reset with valid token', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    \Pest\Laravel\post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
        $response = \Pest\Laravel\post('/reset-password', [
            'token'                 => $notification->token,
            'email'                 => $user->email,
            'password'              => 'Password1',
            'password_confirmation' => 'Password1',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(200);

        return true;
    });
});
