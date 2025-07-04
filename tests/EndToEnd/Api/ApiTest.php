<?php

use Illuminate\Support\Facades\Http;

it('test next js api', function () {

    Http::dd()
        ->withUrlParameters([
            'base' => config()->string('app.frontend_url'),
            'version' => 'v1',
            'userId' => 123,
            'endpoint' => 'profile',
        ])
        ->get('{+base}/{version}/users/{userId}/{endpoint}?include=settings');
})->skip();
