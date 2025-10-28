<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

it('can get csrf cookie', function (): void {

    $response = \Pest\Laravel\get(route('sanctum.csrf-cookie'));

    expect($response->assertNoContent());
});
