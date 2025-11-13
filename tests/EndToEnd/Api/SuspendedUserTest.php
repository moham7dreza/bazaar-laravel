<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use function Pest\Laravel\travelTo;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertModelExists;
use App\Console\Commands\User\UserSuspendClearCommand;
use App\Models\User;

it('can not get response from api', function (): void {

    $user = User::factory()->suspended()->create();

    $response = asUser($user)->getJson(route('api.cities.index'));

    $response->assertForbidden();

    travelTo(Date::now()->addDays(8));

    artisan(UserSuspendClearCommand::class);

    $response = asUser($user)->getJson(route('api.cities.index'));

    $response->assertOk();

    assertModelExists($user);
});
