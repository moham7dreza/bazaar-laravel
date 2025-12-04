<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Panel;

use App\Enums\UserPermission;
use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Gallery;

use function Pest\Laravel\assertModelExists;

it('can list advertisement galleries', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->for($user)->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    $response = asUser($user)
        ->getJson(route('api.panel.advertisements.gallery.index', $advertisement))
        ->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)
        ->id->toBe($gallery->id)
        ->url->toBeString()
        ->position->toBeInt();

    assertModelExists($gallery);
});

it('can create gallery for advertisement', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->for($user)->create();

    $payload = [
        'url'      => 'https://example.com/image.jpg',
        'position' => 1,
    ];

    $response = asUser($user)
        ->postJson(route('api.panel.advertisements.gallery.store', $advertisement), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->url->toBe(Arr::get($payload, 'url'))
        ->position->toBe(Arr::get($payload, 'position'))
        ->advertisement_id->toBe($advertisement->id);

    $gallery = Gallery::query()->firstWhere([
        'advertisement_id' => $advertisement->id,
        'url'              => Arr::get($payload, 'url'),
    ]);

    assertModelExists($gallery);
});

it('can show specific gallery', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->for($user)->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    $response = asUser($user)
        ->getJson(route('api.panel.advertisements.gallery.show', $gallery))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($gallery->id)
        ->url->toBeString()
        ->position->toBeInt();
});

it('can update gallery', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->for($user)->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    $payload = [
        'url'      => 'https://example.com/updated.jpg',
        'position' => 5,
    ];

    $response = asUser($user)
        ->putJson(route('api.panel.advertisements.gallery.update', $gallery), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->url->toBe(Arr::get($payload, 'url'))
        ->position->toBe(Arr::get($payload, 'position'));

    $gallery->refresh();

    expect($gallery->url)->toBe(Arr::get($payload, 'url'))
        ->and($gallery->position)->toBe(Arr::get($payload, 'position'));
});

it('can delete gallery', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->for($user)->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    asUser($user)
        ->deleteJson(route('api.panel.advertisements.gallery.destroy', $gallery))
        ->assertNoContent();

    expect(Gallery::query()
        ->find($gallery->id))->toBeNull();
});

it('cannot access other users gallery', function (): void {
    $user          = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $otherUser     = User::factory()->create()->givePermissionTo(UserPermission::EditAds);
    $advertisement = Advertisement::factory()->for($otherUser)->create();

    asUser($user)
        ->getJson(route('api.panel.advertisements.gallery.index', $advertisement))
        ->assertForbidden();
});
