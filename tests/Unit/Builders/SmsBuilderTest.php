<?php

use App\Builders\SmsBuilder;
use App\Models\User;
use Illuminate\Support\Facades\Lang;

beforeEach(function () {
    Lang::addLines([
        'sms.welcome' => 'Hello :name, click :link to continue.',
        'sms.notify' => 'Hi :user, your item :item is ready.',
        'sms.templates.2' => 'temp2 :body'
    ], 'fa');
});

it('builds a message with a template', function () {
    $msg = SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali', 'link' => 'https://x.com'])
        ->build();

    expect($msg)->toBe('temp2 Hello Ali, click https://x.com to continue.');
});

it('builds a message without a template', function () {
    $msg = SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali', 'link' => 'https://x.com'])
        ->noMessageTemplate()
        ->build();

    expect($msg)->toBe('Hello Ali, click https://x.com to continue.');
});

it('uses a custom message template', function () {
    $message = SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali', 'link' => 'https://x.com'])
        ->messageTemplate(2)
        ->build();

    expect($message)->toBe('temp2 Hello Ali, click https://x.com to continue.');
});

it('throws if message key does not start with sms.', function () {
    SmsBuilder::make('invalid.key');
})->throws(InvalidArgumentException::class, "The message key must start with 'sms.'");

it('throws if message key does not exist', function () {
    SmsBuilder::make('sms.not_existing');
})->throws(InvalidArgumentException::class, "The [sms.not_existing] message key does not exist in translations.");

it('throws if parameters are missing', function () {
    SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali']) // missing link
        ->build();
})->throws(RuntimeException::class, "Missing parameters for sms.welcome: link");

it('throws when "link" is provided manually while path() is used', function () {
    $user = User::factory()->make();

    SmsBuilder::make('sms.welcome')
        ->path('/verify', $user)
        ->parameters(['name' => 'Ali', 'link' => 'should-not-set'])
        ->build();
})->throws(RuntimeException::class, "The 'link' parameter is reserved and must not be provided in the parameters array.");

it('throws if path used with token but user is not set', function () {
    SmsBuilder::make('sms.welcome')
        ->withToken()
        ->build();
})->throws(RuntimeException::class, "User must be provided through the `path()` method to generate auth token.");


