<?php

namespace Tests\EndToEnd;

use Illuminate\Http\Response;

it('can get csrf cookie', function () {

    $response = $this->get(route('sanctum.csrf-cookie'));

    expect($response->assertStatus(Response::HTTP_NO_CONTENT));
});
