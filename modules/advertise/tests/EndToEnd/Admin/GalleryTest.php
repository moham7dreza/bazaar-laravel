<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Gallery;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->makeAdmin();
});

it('can list all galleries for advertisement', function (): void {
    $advertisement = Advertisement::factory()->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.gallery.index', $advertisement))
        ->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    assertModelExists($gallery);
});

it('can create gallery for advertisement', function (): void {
    $advertisement = Advertisement::factory()->create();

    $payload = [
        'url'      => 'https://example.com/admin-image.jpg',
        'position' => 1,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.advertisements.gallery.store', $advertisement), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->url->toBe(Arr::get($payload, 'url'))
        ->position->toBe(Arr::get($payload, 'position'));

    $gallery = Gallery::query()->firstWhere([
        'advertisement_id' => $advertisement->id,
        'url'              => Arr::get($payload, 'url'),
    ]);

    assertModelExists($gallery);
});

it('can show specific gallery', function (): void {
    $advertisement = Advertisement::factory()->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.gallery.show', [$advertisement, $gallery]))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($gallery->id)
        ->url->toBeString();
});

it('can update gallery', function (): void {
    $advertisement = Advertisement::factory()->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    $payload = [
        'url'      => 'https://example.com/updated-admin.jpg',
        'position' => 10,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.advertisements.gallery.update', [$advertisement, $gallery]), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->url->toBe(Arr::get($payload, 'url'))
        ->position->toBe(Arr::get($payload, 'position'));

    $gallery->refresh();

    expect($gallery->url)->toBe(Arr::get($payload, 'url'));
});

it('can delete gallery', function (): void {
    $advertisement = Advertisement::factory()->create();
    $gallery       = Gallery::factory()->for($advertisement)->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.advertisements.gallery.destroy', [$advertisement, $gallery]))
        ->assertNoContent();

    expect(Gallery::query()
        ->find($gallery->id))->toBeNull();
});
