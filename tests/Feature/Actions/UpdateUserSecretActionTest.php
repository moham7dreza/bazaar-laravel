<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserSecretAction;
use App\Models\User;
use Illuminate\Support\Arr;

test('UpdateUserSecretAction updates user mobile number', function (): void {

    $user = User::factory()->create();

    expect($user->secrets->toArray())->toHaveKeys(['stripe', 'open_ai']);

    $updatedUser = UpdateUserSecretAction::dispatch($user, 'password', $password = '123456');

    expect(Arr::get($updatedUser->secrets, 'password'))->toBe($password)
        ->and(Arr::get($user->fresh()->secrets, 'password'))->toBe($password);
});
