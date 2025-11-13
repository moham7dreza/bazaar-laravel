<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

use function Pest\Laravel\get;

it('can get csrf cookie', function (): void {

    $response = get(route('sanctum.csrf-cookie'));

    expect($response->assertNoContent());
});
