<?php

declare(strict_types=1);

use App\Console\Commands\User\UserSuspendClearCommand;
use App\Jobs\UserSuspendClearJob;
use App\Models\User;

test('schedule user suspend clear job pushed', function (): void {

    Queue::fake();

    User::factory()->suspended()->create();

    $this->travelTo(now()->addDays(8));

    $this->artisan(UserSuspendClearCommand::class);

    Queue::assertPushed(UserSuspendClearJob::class);

    $suspendedUsers = User::query()->suspended()->count();

    expect($suspendedUsers)->toBe(0);
});
