<?php

declare(strict_types=1);

use Modules\Advertise\Models\State;

it('can get all parent states', function (): void {

    $state = State::factory()
        ->for(State::factory(), 'parent')
        ->create();

    expect($state->parent_id)->not->toBeNull();

    $response = \Pest\Laravel\getJson(route('api.states.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(4)
        ->id->toBe($state->parent_id)
        ->name->toBeString()
        ->icon->toBeString()
        ->children->toBeArray();

    Pest\Laravel\assertModelExists($state);
});
