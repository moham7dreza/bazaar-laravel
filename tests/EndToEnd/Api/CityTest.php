<?php

declare(strict_types=1);

use App\Models\Geo\City;

it('can get all active cities', function (): void {

    $city = City::factory()->create();

    $response = $this->getJson(route('api.cities.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)
        ->id->toBe($city->id)
        ->name->toBeString()
        ->status->toBeBool();

    Pest\Laravel\assertModelExists($city);
});
