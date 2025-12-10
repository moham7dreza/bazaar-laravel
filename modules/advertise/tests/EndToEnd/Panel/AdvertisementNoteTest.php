<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Panel;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelExists;

it('can list all notes for authenticated user', function (): void {
    $user          = User::factory()->create();
    $advertisement = Advertisement::factory()->for($user)->create();
    $note          = AdvertisementNote::factory()->for($advertisement)->create();

    $response = asUser($user)
        ->getJson(route('api.panel.advertisements.note.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($note);
});

it('can create note for advertisement', function (): void {
    $user          = User::factory()->create();
    $advertisement = Advertisement::factory()->for($user)->create();

    $payload = [
        'note' => 'This is a test note for the advertisement.',
    ];

    $response = asUser($user)
        ->postJson(route('api.panel.advertisements.note.store', $advertisement), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->note->toBe(Arr::get($payload, 'note'))
        ->advertisement_id->toBe($advertisement->id);

    assertDatabaseHas('advertisement_notes', [
        'advertisement_id' => $advertisement->id,
        'note'             => Arr::get($payload, 'note'),
    ]);
});

it('requires note content when creating', function (): void {
    $user          = User::factory()->create();
    $advertisement = Advertisement::factory()->for($user)->create();

    asUser($user)
        ->postJson(route('api.panel.advertisements.note.store', $advertisement), [])
        ->assertUnprocessable();
});

it('can show notes for specific advertisement', function (): void {
    $user          = User::factory()->create();
    $advertisement = Advertisement::factory()->for($user)->create();
    AdvertisementNote::factory()->for($advertisement)->count(3)->create();

    $response = asUser($user)
        ->getJson(route('api.panel.advertisements.note.show', $advertisement))
        ->assertOk();

    expect($response->json('data'))->toHaveLength(3);

    $firstNote = $response->json('data.0');
    expect($firstNote)
        ->id->toBeInt()
        ->note->toBeString()
        ->advertisement_id->toBe($advertisement->id);
});

it('can show notes for trashed advertisement', function (): void {
    $user          = User::factory()->create();
    $advertisement = Advertisement::factory()->for($user)->create();
    $note          = AdvertisementNote::factory()->for($advertisement)->create();

    $advertisement->delete();

    $response = asUser($user)
        ->getJson(route('api.panel.advertisements.note.show', $advertisement->id))
        ->assertOk();

    expect($response->json('data'))->toBeArray();
});

it('can delete all notes for advertisement', function (): void {
    $user          = User::factory()->create();
    $advertisement = Advertisement::factory()->for($user)->create();
    AdvertisementNote::factory()->for($advertisement)->count(2)->create();

    asUser($user)
        ->deleteJson(route('api.panel.advertisements.note.destroy', $advertisement))
        ->assertNoContent();

    expect(AdvertisementNote::query()
        ->where('advertisement_id', $advertisement->id)->count())->toBe(0);
});

it('cannot access other users notes when listing all', function (): void {
    $user      = User::factory()->create();
    $otherUser = User::factory()->create();

    $ownAd   = Advertisement::factory()->for($user)->create();
    $otherAd = Advertisement::factory()->for($otherUser)->create();

    AdvertisementNote::factory()->for($ownAd)->create(['note' => 'Own note']);
    AdvertisementNote::factory()->for($otherAd)->create(['note' => 'Other note']);

    $response = asUser($user)
        ->getJson(route('api.panel.advertisements.note.index'))
        ->assertOk();

    $notes = $response->json('data');

    // Should only see own notes
    expect($notes)->toBeArray();

    foreach ($notes as $note)
    {
        $ad = Advertisement::query()
            ->find(Arr::get($note, 'advertisement_id'));
        expect($ad->user_id)->toBe($user->id);
    }
});

it('cannot create note for other users advertisement', function (): void {
    $user          = User::factory()->create();
    $otherUser     = User::factory()->create();
    $advertisement = Advertisement::factory()->for($otherUser)->create();

    $payload = ['note' => 'Should not be allowed'];

    asUser($user)
        ->postJson(route('api.panel.advertisements.note.store', $advertisement), $payload)
        ->assertForbidden();
});

it('cannot view other users advertisement notes', function (): void {
    $user          = User::factory()->create();
    $otherUser     = User::factory()->create();
    $advertisement = Advertisement::factory()->for($otherUser)->create();
    AdvertisementNote::factory()->for($advertisement)->create();

    asUser($user)
        ->getJson(route('api.panel.advertisements.note.show', $advertisement))
        ->assertForbidden();
});

it('cannot delete other users advertisement notes', function (): void {
    $user          = User::factory()->create();
    $otherUser     = User::factory()->create();
    $advertisement = Advertisement::factory()->for($otherUser)->create();
    AdvertisementNote::factory()->for($advertisement)->create();

    asUser($user)
        ->deleteJson(route('api.panel.advertisements.note.destroy', $advertisement))
        ->assertForbidden();
});
