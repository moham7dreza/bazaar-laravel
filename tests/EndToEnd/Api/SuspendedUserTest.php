<?php

use App\Console\Commands\User\UserSuspendClearCommand;
use App\Models\User;

it('can not get response from api', function (): void {

    $user = User::factory()->suspended()->create();

    $response = asUser($user)->getJson(route('cities.index'));

    $response->assertForbidden();

    $this->travelTo(now()->addDays(8));

    $this->artisan(UserSuspendClearCommand::class);

    $response = asUser($user)->getJson(route('cities.index'));

    $response->assertOk();

    $this->assertModelExists($user);
});
