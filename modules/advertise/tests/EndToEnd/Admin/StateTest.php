<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Advertise\Models\State;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->makeAdmin();
});

it('can list all states', function (): void {
    $state = State::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.state.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($state);
});

it('can create state', function (): void {
    $payload = [
        'name'   => 'California',
        'status' => true,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.advertisements.state.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->name->toBe(Arr::get($payload, 'name'))
        ->status->toBe(Arr::get($payload, 'status'));

    $state = State::query()->firstWhere('name', Arr::get($payload, 'name'));

    assertModelExists($state);
});

it('can show specific state', function (): void {
    $state = State::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.advertisements.state.show', $state))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($state->id)
        ->name->toBe($state->name);
});

it('can update state', function (): void {
    $state = State::factory()->create();

    $payload = [
        'name'   => 'Updated State',
        'status' => false,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.advertisements.state.update', $state), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->name->toBe(Arr::get($payload, 'name'))
        ->status->toBe(Arr::get($payload, 'status'));

    $state->refresh();

    expect($state->name)->toBe(Arr::get($payload, 'name'))
        ->and($state->status)->toBe(Arr::get($payload, 'status'));
});

it('can delete state', function (): void {
    $state = State::factory()->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.advertisements.state.destroy', $state))
        ->assertNoContent();

    expect(State::query()
        ->find($state->id))->toBeNull();
});
