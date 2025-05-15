<?php

declare(strict_types=1);

use App\Enums\Queue as Q;

test('can batch update 1000 users', function (): void {

    //    Queue::fake();

    $this->artisan('db:seed', ['--class' => Database\Seeders\UserBatchSeeder::class]);

    $this->artisan(App\Console\Commands\User\UserBatchUpdateCommand::class)->assertSuccessful();

    //    Queue::assertPushedOn(Q::LOW->value, App\Jobs\UserUpdateJob::class);

    $sentSmsCount = App\Models\SmsLog::query()->count();

    dd($sentSmsCount);
});
