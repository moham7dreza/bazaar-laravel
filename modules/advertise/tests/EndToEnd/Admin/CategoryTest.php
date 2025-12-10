<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\Category;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->admin()->create();
});

it('can list all categories', function (): void {
    $category = Category::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.category.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($category);
});

it('can create category', function (): void {
    $payload = [
        'name'        => 'Electronics',
        'slug'        => 'electronics',
        'description' => 'All electronic items',
        'icon'        => 'icon-electronics',
        'status'      => true,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.advertisements.category.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->name->toBe(Arr::get($payload, 'name'))
        ->slug->toBe(Arr::get($payload, 'slug'));

    $category = Category::query()->firstWhere('slug', Arr::get($payload, 'slug'));

    assertModelExists($category);
});

it('can show specific category', function (): void {
    $category = Category::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.category.show', $category))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($category->id)
        ->name->toBe($category->name);
});

it('can update category', function (): void {
    $category = Category::factory()->create();

    $payload = [
        'name'        => 'Updated Category',
        'slug'        => 'updated-category',
        'description' => 'Updated description',
        'status'      => false,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.advertisements.category.update', $category), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->name->toBe(Arr::get($payload, 'name'))
        ->slug->toBe(Arr::get($payload, 'slug'));

    $category->refresh();

    expect($category->name)->toBe(Arr::get($payload, 'name'))
        ->and($category->slug)->toBe(Arr::get($payload, 'slug'));
});

it('can delete category', function (): void {
    $category = Category::factory()->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.advertisements.category.destroy', $category))
        ->assertNoContent();

    expect(Category::query()
        ->find($category->id))->toBeNull();
});

it('non-admin cannot access category admin routes', function (): void {
    $user = User::factory()->create();

    asUser($user)
        ->getJson(route('api.admin.advertisements.category.index'))
        ->assertForbidden();
});
