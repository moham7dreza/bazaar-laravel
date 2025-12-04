<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->makeAdmin();
});

it('can list all category values', function (): void {
    $attribute = CategoryAttribute::factory()->create();
    $value     = CategoryValue::factory()->for($attribute, 'categoryAttribute')->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.category-value.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($value);
});

it('can create category value', function (): void {
    $attribute = CategoryAttribute::factory()->create();

    $payload = [
        'value'                 => 'Samsung',
        'type'                  => 1,
        'status'                => true,
        'category_attribute_id' => $attribute->id,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.advertisements.category-value.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->value->toBe(Arr::get($payload, 'value'))
        ->type->toBe(Arr::get($payload, 'type'));

    $value = CategoryValue::query()->firstWhere('value', Arr::get($payload, 'value'));

    assertModelExists($value);
});

it('can show specific category value', function (): void {
    $attribute = CategoryAttribute::factory()->create();
    $value     = CategoryValue::factory()->for($attribute, 'categoryAttribute')->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.category-value.show', $value))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($value->id)
        ->value->toBe($value->value);
});

it('can update category value', function (): void {
    $attribute = CategoryAttribute::factory()->create();
    $value     = CategoryValue::factory()->for($attribute, 'categoryAttribute')->create();

    $payload = [
        'value'  => 'Updated Value',
        'type'   => 2,
        'status' => false,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.advertisements.category-value.update', $value), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->value->toBe(Arr::get($payload, 'value'))
        ->type->toBe(Arr::get($payload, 'type'));

    $value->refresh();

    expect($value->value)->toBe(Arr::get($payload, 'value'))
        ->and($value->type)->toBe(Arr::get($payload, 'type'));
});

it('can delete category value', function (): void {
    $attribute = CategoryAttribute::factory()->create();
    $value     = CategoryValue::factory()->for($attribute, 'categoryAttribute')->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.advertisements.category-value.destroy', $value))
        ->assertNoContent();

    expect(CategoryValue::query()
        ->find($value->id))->toBeNull();
});
