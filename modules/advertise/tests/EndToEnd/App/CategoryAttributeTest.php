<?php

declare(strict_types=1);

use Modules\Advertise\Models\Category;
use Modules\Advertise\Models\CategoryAttribute;

use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\getJson;

it('can get category attributes from app', function (): void {

    $category = Category::factory()
        ->has(CategoryAttribute::factory()->count(3), 'attributes')
        ->create();

    $response = getJson(route('api.advertisements.category.attributes.index', $category))->assertOk();

    expect($response->json('data'))->toHaveLength(3);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(8)
        ->id->toBeInt()
        ->name->toBeString()
        ->unit->toBeString()
        ->type->toBeInt()
        ->status->toBeBool()
        ->created_at->toBeString()
        ->updated_at->toBeString()
        ->category->toBeArray();

    assertModelExists($category);
});
