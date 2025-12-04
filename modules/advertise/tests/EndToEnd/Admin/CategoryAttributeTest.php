<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\Category;
use Modules\Advertise\Models\CategoryAttribute;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->makeAdmin();
});

it('can list all category attributes', function (): void {
    $category  = Category::factory()->create();
    $attribute = CategoryAttribute::factory()->for($category)->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.category-attributes.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($attribute);
});

it('can create category attribute', function (): void {
    $category = Category::factory()->create();

    $payload = [
        'name'        => 'Brand',
        'unit'        => 'text',
        'type'        => 1,
        'status'      => true,
        'category_id' => $category->id,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.advertisements.category-attributes.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->name->toBe(Arr::get($payload, 'name'))
        ->unit->toBe(Arr::get($payload, 'unit'))
        ->type->toBe(Arr::get($payload, 'type'));

    $attribute = CategoryAttribute::query()->firstWhere('name', Arr::get($payload, 'name'));

    assertModelExists($attribute);
});

it('can show specific category attribute', function (): void {
    $category  = Category::factory()->create();
    $attribute = CategoryAttribute::factory()->for($category)->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.category-attributes.show', $attribute))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($attribute->id)
        ->name->toBe($attribute->name);
});

it('can update category attribute', function (): void {
    $category  = Category::factory()->create();
    $attribute = CategoryAttribute::factory()->for($category)->create();

    $payload = [
        'name'   => 'Updated Attribute',
        'unit'   => 'updated-unit',
        'type'   => 2,
        'status' => false,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.advertisements.category-attributes.update', $attribute), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->name->toBe(Arr::get($payload, 'name'))
        ->unit->toBe(Arr::get($payload, 'unit'));

    $attribute->refresh();

    expect($attribute->name)->toBe(Arr::get($payload, 'name'))
        ->and($attribute->unit)->toBe(Arr::get($payload, 'unit'));
});

it('can delete category attribute', function (): void {
    $category  = Category::factory()->create();
    $attribute = CategoryAttribute::factory()->for($category)->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.advertisements.category-attributes.destroy', $attribute))
        ->assertNoContent();

    expect(CategoryAttribute::query()
        ->find($attribute->id))->toBeNull();
});
