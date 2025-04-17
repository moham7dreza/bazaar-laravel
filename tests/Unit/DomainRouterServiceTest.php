<?php

use App\Http\Services\DomainRouter;
use App\Enums\Environment;
use Illuminate\Http\Request;

it('generates routes for production environment', function () {
    $request = mock(Request::class);
    $request->shouldReceive('host')->andReturn('example.ir');
    $request->shouldReceive('schemeAndHttpHost')->andReturn('https://example.ir');
    $request->shouldReceive('httpHost')->andReturn('example.ir');

    $router = new DomainRouter();
    $routes = $router->generateRoutes($request);

    expect($routes)->toBe([
        'api' => 'https://example.ir/api',
        'web' => 'example.ir',
        'assets' => 'https://example.ir',
        'environment' => Environment::PRODUCTION->value,
    ]);
});

it('generates routes for staging environment', function () {
    $request = mock(Request::class);
    $request->shouldReceive('host')->andReturn('api.dev.example.com');
    $request->shouldReceive('schemeAndHttpHost')->andReturn('https://api.dev.example.com');
    $request->shouldReceive('httpHost')->andReturn('api.dev.example.com');

    $router = new DomainRouter();
    $routes = $router->generateRoutes($request);

    expect($routes)->toBe([
        'api' => 'https://api.dev.example.com/api',
        'web' => 'staging.dev.example.com',
        'assets' => 'https://staging-cdn.dev.example.com',
        'environment' => Environment::STAGING->value,
    ]);
});

it('generates routes for local environment', function () {
    $request = mock(Request::class);
    $request->shouldReceive('host')->andReturn('localhost');
    $request->shouldReceive('schemeAndHttpHost')->andReturn('http://localhost:9000');
    $request->shouldReceive('httpHost')->andReturn('localhost');

    $router = new DomainRouter();
    $routes = $router->generateRoutes($request);

    expect($routes)->toBe([
        'api' => 'http://localhost:9000/api',
        'web' => 'http://localhost:3000',
        'assets' => 'http://localhost:9000',
        'environment' => Environment::LOCAL->value,
    ]);
});
