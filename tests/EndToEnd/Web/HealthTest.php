<?php

declare(strict_types=1);

use App\Models\User;

it('can get health checks', function (): void {

    $user = User::factory()->admin()->create();

    $response = asAdminUser($user)->getJson(route('monitoring.health-custom'))->assertOk();

    expect($response->json('data'))->toHaveLength(11);
});
