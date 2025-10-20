<?php

declare(strict_types=1);

use App\Console\Commands\User\UserSuspendClearCommand;
use App\Models\User;

it('can not get response from api', function (): void {

    $user = User::factory()->suspended()->create();

    $response = asUser($user)->getJson(route('api.cities.index'));

    $response->assertForbidden();

    Pest\Laravel\travelTo(now()->addDays(8));

    Pest\Laravel\artisan(UserSuspendClearCommand::class);

    $response = asUser($user)->getJson(route('api.cities.index'));

    $response->assertOk();

    Pest\Laravel\assertModelExists($user);
});
