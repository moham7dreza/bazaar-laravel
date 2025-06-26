<?php

use App\Builders\SmsBuilder;
use App\Models\User;
use Illuminate\Support\Facades\Lang;

beforeEach(function () {
    Lang::addLines([
        'sms.welcome' => 'Hello :name, click :link to continue.',
        'sms.templates.2' => 'temp2 :body'
    ], 'fa');
});

it('adds token to URL if withToken is set', function () {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/verify', $user)
        ->withToken('test-token')
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('builds a message with dynamic shortlink and token', function () {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/verify', $user)
        ->queryParams(['ref' => 'abc'])
        ->withToken('TestToken', ['*'], now()->addMinutes(5))
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('overrides baseUrl', function () {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/custom', $user)
        ->baseUrl('https://custom-domain.com')
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('handles multiple query params in path', function () {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/link', $user)
        ->queryParams(['a' => 1, 'b' => 'x'])
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('defaults to user domain if baseUrl is not set', function () {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/default', $user)
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});
