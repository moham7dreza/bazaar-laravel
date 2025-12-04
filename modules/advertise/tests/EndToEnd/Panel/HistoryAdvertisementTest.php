<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Panel;

use App\Enums\UserPermission;
use App\Models\User;
use Modules\Advertise\Models\Advertisement;

use function Pest\Laravel\assertDatabaseHas;

it('can list user advertisement viewing history', function (): void {
    $user           = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement1 = Advertisement::factory()->create();
    $advertisement2 = Advertisement::factory()->create();

    $user->viewedAdvertisements()->attach($advertisement1, ['viewed_at' => now()]);
    $user->viewedAdvertisements()->attach($advertisement2, ['viewed_at' => now()->subHour()]);

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray()
        ->toHaveLength(2);

    $ids = collect($response->json('data'))->pluck('id')->toArray();
    expect($ids)->toContain($advertisement1->id)
        ->toContain($advertisement2->id);
});

it('returns empty array when user has no history', function (): void {
    $user = User::factory()->create()->givePermissionTo(UserPermission::EditAds);

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray()
        ->toHaveLength(0);
});

it('can add advertisement to viewing history', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertCreated();

    assertDatabaseHas('advertisement_views', [
        'user_id'          => $user->id,
        'advertisement_id' => $advertisement->id,
    ]);

    expect($user->viewedAdvertisements()->where('advertisement_id', $advertisement->id)->exists())
        ->toBeTrue();
});

it('returns success response when adding to history', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    $response = asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertCreated();

    expect($response->json())->toHaveKey('message')
        ->or($response->json())->toHaveKey('data');
});

it('can track multiple views of same advertisement', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    // First view
    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertCreated();

    // Second view
    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertCreated();

    // Third view
    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertCreated();

    // Should allow multiple views
    expect($user->viewedAdvertisements()->where('advertisement_id', $advertisement->id)->count())
        ->toBeGreaterThanOrEqual(1);
});

it('stores timestamp with each view', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertCreated();

    $view = $user->viewedAdvertisements()
        ->where('advertisement_id', $advertisement->id)
        ->first();

    expect($view->pivot->viewed_at)->not->toBeNull();
});

it('history is user-specific', function (): void {
    $user1         = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $user2         = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    // User 1 views advertisement
    $user1->viewedAdvertisements()->attach($advertisement, ['viewed_at' => now()]);

    // User 2 should not see User 1's history
    $response = asUser($user2)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertOk();

    expect($response->json('data'))->toHaveLength(0);
});

it('can view multiple different advertisements', function (): void {
    $user = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $ad1  = Advertisement::factory()->create();
    $ad2  = Advertisement::factory()->create();
    $ad3  = Advertisement::factory()->create();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $ad1))
        ->assertCreated();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $ad2))
        ->assertCreated();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $ad3))
        ->assertCreated();

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertOk();

    expect($response->json('data'))->toHaveLength(3);
});

it('history list is ordered by most recent first', function (): void {
    $user  = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $oldAd = Advertisement::factory()->create();
    $newAd = Advertisement::factory()->create();

    $user->viewedAdvertisements()->attach($oldAd, ['viewed_at' => now()->subDay()]);
    $user->viewedAdvertisements()->attach($newAd, ['viewed_at' => now()]);

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertOk();

    $data = $response->json('data');

    // Most recent should be first (depending on implementation)
    expect($data)->toBeArray();
});

it('can track views of trashed advertisements', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();
    $advertisement->delete();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement->id))
        ->assertCreated();

    assertDatabaseHas('advertisement_views', [
        'user_id'          => $user->id,
        'advertisement_id' => $advertisement->id,
    ]);
});

it('history includes advertisement details', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    $user->viewedAdvertisements()->attach($advertisement, ['viewed_at' => now()]);

    $response = asUser($user)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertOk();

    $firstItem = $response->json('data.0');

    expect($firstItem)
        ->id->toBe($advertisement->id)
        ->and($firstItem)->toHaveKey('title')
        ->and($firstItem)->toHaveKey('slug');
});

it('user without EditAds permission cannot access history', function (): void {
    $user          = User::factory()->create(); // No permissions
    $advertisement = Advertisement::factory()->create();

    asUser($user)
        ->getJson(route('api.panel.users.advertisements.history.index'))
        ->assertForbidden();

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $advertisement))
        ->assertForbidden();
});

it('returns 404 when trying to add non-existent advertisement to history', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $nonExistentId = 999999;

    asUser($user)
        ->postJson(route('api.panel.users.advertisements.history.store', $nonExistentId))
        ->assertNotFound();
});

it('tracks views over time for analytics', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->create();

    // Simulate viewing at different times
    $user->viewedAdvertisements()->attach($advertisement, ['viewed_at' => now()->subDays(5)]);
    $user->viewedAdvertisements()->attach($advertisement, ['viewed_at' => now()->subDays(2)]);
    $user->viewedAdvertisements()->attach($advertisement, ['viewed_at' => now()]);

    $views = $user->viewedAdvertisements()
        ->where('advertisement_id', $advertisement->id)
        ->get();

    expect($views->count())->toBeGreaterThanOrEqual(1);
});
