<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use App\Models\User;
use App\Services\Builders\SmsBuilder;
use Illuminate\Support\Facades\Lang;

beforeEach(function (): void {
    Lang::addLines([
        'sms.welcome'     => 'Hello :name, click :link to continue.',
        'sms.templates.2' => 'temp2 :body',
    ], 'fa');
});

it('adds token to URL if withToken is set', function (): void {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/verify', $user)
        ->withToken('test-token')
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('builds a message with dynamic shortlink and token', function (): void {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/verify', $user)
        ->queryParams(['ref' => 'abc'])
        ->withToken('TestToken', ['*'], Date::now()->addMinutes(5))
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('overrides baseUrl', function (): void {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/custom', $user)
        ->baseUrl('https://custom-domain.com')
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('handles multiple query params in path', function (): void {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/link', $user)
        ->queryParams(['a' => 1, 'b' => 'x'])
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('defaults to user domain if baseUrl is not set', function (): void {
    $user = User::factory()->create();

    $message = SmsBuilder::make('sms.welcome')
        ->path('/default', $user)
        ->parameters(['name' => 'Ali'])
        ->build();

    expect($message)->toBeString();
});

it('throws when "link" is provided manually while path() is used', function (): void {
    $user = User::factory()->make();

    SmsBuilder::make('sms.welcome')
        ->path('/verify', $user)
        ->parameters(['name' => 'Ali', 'link' => 'should-not-set'])
        ->build();
})->throws(RuntimeException::class, "The 'link' parameter is reserved and must not be provided in the parameters array.");
