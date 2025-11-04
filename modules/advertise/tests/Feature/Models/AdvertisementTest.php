<?php

declare(strict_types=1);

use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\CategoryAttribute;

it('can check for ad nested relations loaded', function (): void {
    $ad = Advertisement::factory()->create();

    CategoryAttribute::factory()->for($ad->category)->create();

    $ad = Advertisement::query()
        ->with('category.attributes')
        ->first();

    expect($ad->category->attributes()->exists())->toBeTrue()
        ->and($ad->relationLoaded('category'))->toBeTrue()
//        ->and($ad->relationLoaded('category.attributes'))->toBeTrue()
        ->and($ad->category->relationLoaded('attributes'))->toBeTrue();
});
