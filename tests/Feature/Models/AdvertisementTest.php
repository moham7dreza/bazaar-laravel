<?php

use App\Models\Advertise\Advertisement;
use App\Models\User;

it('can load all child menus', function () {

    $ads = Advertisement::factory(2)
        ->hasAttached($users = User::factory(2)->create(), relationship: 'viewedByUsers')
        ->create();

    $viewedAdvertisements = Advertisement::whereAttachedTo($users, 'viewedByUsers');

    $intersect = $viewedAdvertisements->pluck('id')->intersect($ads->pluck('id'))->count();

    expect($intersect)->toBe(2);
});
