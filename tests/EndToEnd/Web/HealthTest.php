<?php

use App\Models\User;

it('can get health checks', function (): void {

    $user = User::factory()->admin()->create();

    $response = asAdminUser($user)->getJson(route('web.health-custom'))->assertOk();

    expect($response->json('data'))->toHaveLength(11);
});
