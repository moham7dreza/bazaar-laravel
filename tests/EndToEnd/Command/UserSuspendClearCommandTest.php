<?php

use App\Console\Commands\UserSuspendClearCommand;
use App\Jobs\UserSuspendClearJob;
use App\Models\User;

test('schedule user suspend clear job pushed', function () {

    Queue::fake();

    User::factory()->suspended()->create();

    $this->travelTo(now()->addDays(8));

    $this->artisan(UserSuspendClearCommand::class);

    Queue::assertPushed(UserSuspendClearJob::class);

    $suspendedUsers = User::query()->suspended()->count();

    expect($suspendedUsers)->toBe(0);
});
