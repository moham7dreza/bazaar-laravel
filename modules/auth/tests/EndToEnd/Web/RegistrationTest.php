<?php

declare(strict_types=1);

test('new users can register', function (): void {
    $response = \Pest\Laravel\post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
        'mobile'                => '09141234567',
    ]);

    Pest\Laravel\assertAuthenticated();
    $response->assertNoContent();
});
