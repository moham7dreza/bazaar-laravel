<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('test next js api', function (): void {

    Http::dd()
        ->retry(3, 100)
        ->withUrlParameters([
            'base'     => config()->string('app.frontend_url'),
            'version'  => 'v1',
            'userId'   => 123,
            'endpoint' => 'profile',
        ])
        ->get('{+base}/{version}/users/{userId}/{endpoint}?include=settings');
})->skip();
