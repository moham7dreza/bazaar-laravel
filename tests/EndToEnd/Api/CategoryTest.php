<?php

use App\Models\Advertise\Category;

it('can get all parent categories', function () {

    Category::factory()->parent(Category::factory())->create();

    $response = $this->getJson(route('categories.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    Category::factory()->create();

    $response = $this->getJson(route('categories.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(2);
});
