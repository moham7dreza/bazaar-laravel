<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tests\TestGroup;

use function Pest\Laravel\getJson;

pest()->group(TestGroup::MANUAL);

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
});

it('can get today', function (): void {

    getJson(route('api.today.date', today()))->ddBody();
});
