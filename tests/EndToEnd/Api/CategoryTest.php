<?php

use App\Models\Advertise\Category;

it('can get all parent categories', function (): void {

    $category = Category::factory()
        ->for(Category::factory(), 'parent')
        ->create();

    expect($category->parent_id)->not->toBeNull();

    $response = $this->getJson(route('categories.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(4)
        ->id->toBe($category->parent_id)
        ->name->toBeString()
        ->slug->toBeString()
        ->icon->toBeString();

    $this->assertModelExists($category);
});
