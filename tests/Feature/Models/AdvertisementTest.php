<?php

use App\Models\Advertise\Advertisement;
use App\Models\Advertise\CategoryAttribute;
use App\Models\User;

it('can get advertisements viewed by users', function (): void {

    $ads = Advertisement::factory(2)
        ->hasAttached($users = User::factory(2)->create(), relationship: 'viewedByUsers')
        ->create();

    $viewedAdvertisements = Advertisement::whereAttachedTo($users, 'viewedByUsers');

    $intersect = $viewedAdvertisements->pluck('id')->intersect($ads->pluck('id'))->count();

    expect($intersect)->toBe(2);
})
    ->skip();

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
