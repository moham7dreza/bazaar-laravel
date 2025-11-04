<?php

declare(strict_types=1);

use App\Console\Commands\User\UserSuspendClearCommand;
use App\Jobs\UserSuspendClearJob;
use App\Models\User;

test('schedule user suspend clear job pushed', function (): void {

    Illuminate\Support\Facades\Queue::fake();

    User::factory()->suspended()->create();

    Pest\Laravel\travelTo(Date::now()->addDays(8));

    Pest\Laravel\artisan(UserSuspendClearCommand::class);

    Illuminate\Support\Facades\Queue::assertPushed(UserSuspendClearJob::class);

    $suspendedUsers = User::query()->suspended()->count();

    expect($suspendedUsers)->toBe(0);
});
