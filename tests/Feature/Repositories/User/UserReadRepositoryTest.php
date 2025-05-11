<?php

declare(strict_types=1);

use App\Models\User;
use App\Repositories\User\UserReadRepository;
use Modules\Advertise\Models\Advertisement;

beforeEach(function (): void {

    $this->sut = app(UserReadRepository::class);
});

it('can load all users with latest advertisement posted dates', function (): void {

    User::factory(2)
        ->has(Advertisement::factory()->state(['created_at' => '2025-05-01']))
        ->create();

    $users = $this->sut->getUsersWithLatestAdvertisementPostedDate()
        ->items
        ->pluck('latest_advertisement_posted_at', 'id')
        ->toArray();

    expect($users)->toContain(
        '2025-05-01 00:00:00',
        '2025-05-01 00:00:00',
    );
});
