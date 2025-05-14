<?php

declare(strict_types=1);

use App\Models\User;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\CategoryAttribute;

it('can get advertisements viewed by users', function (): void {

    $ads = Advertisement::factory(2)
        ->hasAttached($users = User::factory(2)->create(), relationship: 'viewedByUsers')
        ->create();

    $viewedAdvertisements = Advertisement::whereAttachedTo($users, 'viewedByUsers');

    $intersect = $viewedAdvertisements->pluck('id')->intersect($ads->pluck('id'))->count();

    expect($intersect)->toBe(2);
});

it('can check for ad nested relations loaded', function (): void {
    $ad = Advertisement::factory()->create();

    CategoryAttribute::factory()->for($ad->category)->create();

    $ad = Advertisement::query()
        ->with('category.attributes')
        ->first();

    expect($ad->category->attributes()->exists())->toBeTrue()
        ->and($ad->relationLoaded('category'))->toBeTrue()
        ->and($ad->relationLoaded('category.attributes'))->toBeTrue();
});
