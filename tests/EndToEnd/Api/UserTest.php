<?php

use App\Models\User;

it('can see user info', function (): void {

    $user = User::factory()->admin()->create();

    $response = asUser($user)->getJson(route('api.user.info'))->assertOk();

    expect($response->json())->toHaveCount(15)
        ->id->toBeInt()
        ->name->toBeString()
        ->mobile->toBeString();
});
