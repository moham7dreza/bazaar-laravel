<?php

declare(strict_types=1);

use App\Console\Commands\User\UserSuspendClearCommand;
use App\Jobs\UserSuspendClearJob;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\artisan;
use function Pest\Laravel\travelTo;

test('schedule user suspend clear job pushed', function (): void {

    Queue::fake();

    User::factory()->suspended()->create();

    travelTo(Date::now()->addDays(8));

    artisan(UserSuspendClearCommand::class);

    Queue::assertPushed(UserSuspendClearJob::class);

    $suspendedUsers = User::query()->suspended()->count();

    expect($suspendedUsers)->toBe(0);
});
