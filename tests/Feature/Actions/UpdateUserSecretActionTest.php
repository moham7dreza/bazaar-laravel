<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserSecretAction;
use App\Models\User;

test('UpdateUserSecretAction updates user mobile number', function (): void {

    $user = User::factory()->create();

    expect($user->secrets->toArray())->toHaveKeys(['stripe', 'open_ai']);

    $updatedUser = UpdateUserSecretAction::dispatch($user, 'password', $password = '123456');

    expect(Illuminate\Support\Arr::get($updatedUser->secrets, 'password'))->toBe($password)
        ->and(Illuminate\Support\Arr::get($user->fresh()->secrets, 'password'))->toBe($password);
});
