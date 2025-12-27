<?php

declare(strict_types=1);

use function Pest\Laravel\getJson;

it('can get all active cities', function (): void {

    $response = getJson(route('api.cities.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);
});
