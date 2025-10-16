<?php

declare(strict_types=1);

use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;

use function Pest\Laravel\getJson;

it('can get category values from app', function (): void {

    $categoryAttribute = CategoryAttribute::factory()
        ->has(CategoryValue::factory()->count(3))
        ->create();

    $response = getJson(route('advertisements.category.values.index', $categoryAttribute))->assertOk();

    expect($response->json('data'))->toHaveLength(3);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(7)
        ->id->toBeInt()
        ->value->toBeString()
        ->type->toBeInt()
        ->status->toBeBool()
        ->created_at->toBeString()
        ->updated_at->toBeString()
        ->categoryAttribute->toBeArray();

    Pest\Laravel\assertModelExists($categoryAttribute);
});
