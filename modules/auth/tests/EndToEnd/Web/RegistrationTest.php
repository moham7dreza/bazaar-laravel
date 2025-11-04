<?php

declare(strict_types=1);

use function Pest\Laravel\post;

test('new users can register', function (): void {
    $response = post(route('api.auth.register'), [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => $pass = 'asdasdsa@1231DQWD',
        'password_confirmation' => $pass,
        'mobile'                => '09141234567',
    ]);

    Pest\Laravel\assertAuthenticated();
    $response->assertNoContent();
});
