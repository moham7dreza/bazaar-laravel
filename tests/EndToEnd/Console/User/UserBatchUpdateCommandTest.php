<?php

declare(strict_types=1);

use Tests\TestGroup;
use App\Jobs\UserUpdateJob;
use App\Models\User;
use function Pest\Laravel\artisan;
use App\Console\Commands\User\UserBatchUpdateCommand;
use Database\Seeders\UserBatchSeeder;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;

pest()->group(TestGroup::MANUAL);

test('can batch update 1000 users', function (): void {

    Queue::fake();
    Bus::fake();

    artisan('db:seed', ['--class' => UserBatchSeeder::class])->assertSuccessful();

    artisan(UserBatchUpdateCommand::class)->assertSuccessful();

    // 1000 records => 100 records per job => 10 * 100 = 1000
    Bus::assertBatched(static fn (PendingBatch $batch) => 10 === $batch->jobs->count());

    Bus::assertBatched(static fn (PendingBatch $batch) => $batch->jobs->each(function (UserUpdateJob $job): void {
        100 === count(array_intersect($job->ids, User::query()->pluck('id')->toArray()));
    }));
});
