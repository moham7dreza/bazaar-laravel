<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Category;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->makeAdmin();
});

it('can list all advertisements', function (): void {
    $advertisement = Advertisement::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.advertisement.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($advertisement);
});

it('can create advertisement', function (): void {
    $user     = User::factory()->create();
    $category = Category::factory()->create();

    $payload = [
        'title'            => 'Test Advertisement',
        'description'      => 'Test description for advertisement',
        'ads_type'         => 'sale',
        'ads_status'       => 'active',
        'user_id'          => $user->id,
        'category_id'      => $category->id,
        'price'            => 1000,
        'contact'          => '09123456789',
        'is_special'       => false,
        'is_ladder'        => false,
        'willing_to_trade' => false,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.advertisements.advertisement.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->description->toBe(Arr::get($payload, 'description'))
        ->price->toBe(Arr::get($payload, 'price'));

    $advertisement = Advertisement::query()->firstWhere('title', Arr::get($payload, 'title'));

    assertModelExists($advertisement);
});

it('can show specific advertisement', function (): void {
    $advertisement = Advertisement::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.advertisement.show', $advertisement))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($advertisement->id)
        ->title->toBe($advertisement->title);
});

it('can show trashed advertisement', function (): void {
    $advertisement = Advertisement::factory()->create();
    $advertisement->delete();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.advertisement.show', $advertisement))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($advertisement->id);
});

it('can update advertisement', function (): void {
    $advertisement = Advertisement::factory()->create();

    $payload = [
        'title'       => 'Updated Advertisement',
        'description' => 'Updated description',
        'price'       => 2000,
        'is_special'  => true,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.advertisements.advertisement.update', $advertisement), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->description->toBe(Arr::get($payload, 'description'))
        ->price->toBe(Arr::get($payload, 'price'));

    $advertisement->refresh();

    expect($advertisement->title)->toBe(Arr::get($payload, 'title'))
        ->and($advertisement->price)->toBe(Arr::get($payload, 'price'));
});

it('can delete advertisement', function (): void {
    $advertisement = Advertisement::factory()->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.advertisements.advertisement.destroy', $advertisement))
        ->assertNoContent();

    expect(Advertisement::withTrashed()->find($advertisement->id)->trashed())->toBeTrue();
});
