<?php

declare(strict_types=1);

namespace Tests\EndToEnd;

use Illuminate\Http\Response;

it('can get csrf cookie', function (): void {

    $response = \Pest\Laravel\get(route('sanctum.csrf-cookie'));

    expect($response->assertStatus(Response::HTTP_NO_CONTENT));
});
