<?php

declare(strict_types=1);

use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Category;

it('can get all parent categories', function (): void {

    $category = Category::factory()
        ->for(Category::factory(), 'parent')
        ->create();

    Advertisement::factory()->for($category->parent)->create();

    expect($category->parent_id)->not->toBeNull();

    $response = \Pest\Laravel\getJson(route('api.categories.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(4)
        ->id->toBe($category->parent_id)
        ->name->toBeString()
        ->slug->toBeString()
        ->icon->toBeString();

    Pest\Laravel\assertModelExists($category);
});
