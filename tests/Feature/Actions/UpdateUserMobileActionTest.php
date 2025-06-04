<?php

declare(strict_types=1);

use App\Actions\User\UpdateUserMobileAction;
use App\Models\User;

test('UpdateUserMobileAction updates user mobile number', function (): void {

    $user = User::factory()->create(['mobile' => '+1234567890']);

    $newMobile = '+9876543210';

    $updatedUser = UpdateUserMobileAction::dispatch($user, $newMobile);

    expect($updatedUser->mobile)->toBe($newMobile)
        ->and($user->fresh()->mobile)->toBe($newMobile);
});
