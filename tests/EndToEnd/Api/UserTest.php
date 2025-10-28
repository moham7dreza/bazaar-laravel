<?php

declare(strict_types=1);

use App\Models\User;

it('can see user info', function (): void {

    $user = User::factory()->create();

    $response = asUser($user)->getJson(route('api.user.info'))->assertOk();

    expect($response->json())->toHaveCount(18)
        ->id->toBeInt()
        ->name->toBeString()
        ->mobile->toBeString();
});
