<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Panel;

use App\Enums\UserPermission;
use App\Models\User;
use Modules\Advertise\Models\Advertisement;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('can list user favorite advertisements', function (): void {
    $user           = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement1 = Advertisement::factory()->create();
    $advertisement2 = Advertisement::factory()->create();

    $user->favoriteAdvertisements()->attach([$advertisement1->id, $advertisement2->id]);

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.favorite.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray()
        ->toHaveLength(2);

    $ids = collect($response->json('data'))->pluck('id')->toArray();
    expect($ids)->toContain($advertisement1->id)
        ->toContain($advertisement2->id);
});

it('returns empty array when user has no favorites', function (): void {
    $user = User::factory()->create()->givePermissionTo(UserPermission::EditAds);

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.favorite.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray()
        ->toHaveLength(0);
});

it('can add advertisement to favorites', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement))
        ->assertCreated();

    assertDatabaseHas('advertisement_favorites', [
        'user_id'          => $user->id,
        'advertisement_id' => $advertisement->id,
    ]);

    expect($user->favoriteAdvertisements()->where('advertisement_id', $advertisement->id)->exists())
        ->toBeTrue();
});

it('returns success response with favorite data when adding', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    $response = asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement))
        ->assertCreated();

    expect($response->json())->toHaveKey('message')
        ->or($response->json())->toHaveKey('data');
});

it('can remove advertisement from favorites', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();
    $user->favoriteAdvertisements()->attach($advertisement);

    asUser($user)
        ->deleteJson(route('api.panel.users.advertisements.favorite.destroy', $advertisement))
        ->assertNoContent();

    assertDatabaseMissing('advertisement_favorites', [
        'user_id'          => $user->id,
        'advertisement_id' => $advertisement->id,
    ]);

    expect($user->favoriteAdvertisements()->where('advertisement_id', $advertisement->id)->exists())
        ->toBeFalse();
});

it('returns success when removing non-existent favorite', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    // Not favorited, but should not error
    asUser($user)
        ->deleteJson(route('api.panel.users.advertisements.favorite.destroy', $advertisement))
        ->assertNoContent();
});

it('cannot favorite same advertisement twice', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    $user->favoriteAdvertisements()->attach($advertisement);

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement))
        ->assertStatus(422); // or 409 depending on implementation
});

it('can favorite multiple different advertisements', function (): void {
    $user = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $ad1  = Advertisement::factory()->create();
    $ad2  = Advertisement::factory()->create();
    $ad3  = Advertisement::factory()->create();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $ad1))
        ->assertCreated();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $ad2))
        ->assertCreated();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $ad3))
        ->assertCreated();

    expect($user->favoriteAdvertisements()->count())->toBe(3);
});

it('favorites are user-specific', function (): void {
    $user1         = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $user2         = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    // User 1 favorites
    $user1->favoriteAdvertisements()->attach($advertisement);

    // User 2 should not see User 1's favorites
    $response = asUser($user2)
        ->getJson(route('api.panel.users.advertisements.favorite.index'))
        ->assertOk();

    expect($response->json('data'))->toHaveLength(0);
});

it('can favorite and unfavorite same advertisement multiple times', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    // Add favorite
    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement))
        ->assertCreated();

    expect($user->favoriteAdvertisements()->count())->toBe(1);

    // Remove favorite
    asUser($user)
        ->deleteJson(route('api.panel.users.advertisements.favorite.destroy', $advertisement))
        ->assertNoContent();

    expect($user->favoriteAdvertisements()->count())->toBe(0);

    // Add favorite again
    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement))
        ->assertCreated();

    expect($user->favoriteAdvertisements()->count())->toBe(1);
});

it('can favorite trashed advertisements', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();
    $advertisement->delete();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement->id))
        ->assertCreated();

    assertDatabaseHas('advertisement_favorites', [
        'user_id'          => $user->id,
        'advertisement_id' => $advertisement->id,
    ]);
});

it('user without EditAds permission cannot manage favorites', function (): void {
    $user          = User::factory()->create(); // No permissions
    $advertisement = Advertisement::factory()->create();

    asUser($user)
        ->getJson(route('api.panel.users.advertisements.favorite.index'))
        ->assertForbidden();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $advertisement))
        ->assertForbidden();

    asUser($user)
        ->deleteJson(route('api.panel.users.advertisements.favorite.destroy', $advertisement))
        ->assertForbidden();
});

it('returns 404 when trying to favorite non-existent advertisement', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $nonExistentId = 999999;

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.favorite.store', $nonExistentId))
        ->assertNotFound();
});
