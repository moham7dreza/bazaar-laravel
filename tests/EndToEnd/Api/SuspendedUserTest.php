<?php

use App\Console\Commands\UserSuspendClearCommand;
use App\Models\User;

it('can not get response from api', function () {

    $user = User::factory()->suspended()->create();

    $response = asUser($user)->getJson(route('cities.index'));

    $response->assertForbidden();

    $this->travelTo(now()->addDays(8));

    $this->artisan(UserSuspendClearCommand::class);

    $response = asUser($user)->getJson(route('cities.index'));

    $response->assertOk();

    $this->assertModelExists($user);
});
