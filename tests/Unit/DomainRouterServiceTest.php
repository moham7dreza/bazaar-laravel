<?php

use App\Enums\Environment;
use App\Http\Services\DomainRouter;
use Illuminate\Http\Request;

beforeEach(function (): void {
    $this->request = mock(Request::class);

    // define system under test
    $this->sut = new DomainRouter;
});

it('generates routes for production environment', function (): void {

    $this->request->shouldReceive('host')->andReturn('example.ir');
    $this->request->shouldReceive('schemeAndHttpHost')->andReturn('https://example.ir');
    $this->request->shouldReceive('httpHost')->andReturn('example.ir');

    $routes = $this->sut->generateRoutes($this->request);

    expect($routes)->toBe([
        'api' => 'https://example.ir/api',
        'web' => 'example.ir',
        'assets' => 'https://example.ir',
        'environment' => Environment::PRODUCTION->value,
    ]);
});

it('generates routes for staging environment', function (): void {

    $this->request->shouldReceive('host')->andReturn('api.dev.example.com');
    $this->request->shouldReceive('schemeAndHttpHost')->andReturn('https://api.dev.example.com');
    $this->request->shouldReceive('httpHost')->andReturn('api.dev.example.com');

    $routes = $this->sut->generateRoutes($this->request);

    expect($routes)->toBe([
        'api' => 'https://api.dev.example.com/api',
        'web' => 'staging.dev.example.com',
        'assets' => 'https://staging-cdn.dev.example.com',
        'environment' => Environment::STAGING->value,
    ]);
});

it('generates routes for local environment', function (): void {

    $this->request->shouldReceive('host')->andReturn('localhost');
    $this->request->shouldReceive('schemeAndHttpHost')->andReturn('http://localhost:9000');
    $this->request->shouldReceive('httpHost')->andReturn('localhost');

    $routes = $this->sut->generateRoutes($this->request);

    expect($routes)->toBe([
        'api' => 'http://localhost:9000/api',
        'web' => 'http://localhost:3000',
        'assets' => 'http://localhost:9000',
        'environment' => Environment::LOCAL->value,
    ]);
});
