<?php

declare(strict_types=1);

use App\Services\Builders\SmsBuilder;
use Illuminate\Support\Facades\Lang;

beforeEach(function (): void {
    Lang::addLines([
        'sms.welcome'     => 'Hello :name, click :link to continue.',
        'sms.notify'      => 'Hi :user, your item :item is ready.',
        'sms.templates.2' => 'temp2 :body',
    ], 'fa');
});

it('builds a message with a template', function (): void {
    $msg = SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali', 'link' => 'https://x.com'])
        ->build();

    expect($msg)->toBe('temp2 Hello Ali, click https://x.com to continue.');
});

it('builds a message without a template', function (): void {
    $msg = SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali', 'link' => 'https://x.com'])
        ->noMessageTemplate()
        ->build();

    expect($msg)->toBe('Hello Ali, click https://x.com to continue.');
});

it('uses a custom message template', function (): void {
    $message = SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali', 'link' => 'https://x.com'])
        ->messageTemplate(2)
        ->build();

    expect($message)->toBe('temp2 Hello Ali, click https://x.com to continue.');
});

it('throws if message key does not start with sms.', function (): void {
    SmsBuilder::make('invalid.key');
})->throws(InvalidArgumentException::class, "The message key must start with 'sms.'");

it('throws if message key does not exist', function (): void {
    SmsBuilder::make('sms.not_existing');
})->throws(InvalidArgumentException::class, 'The [sms.not_existing] message key does not exist in translations.');

it('throws if parameters are missing', function (): void {
    SmsBuilder::make('sms.welcome')
        ->parameters(['name' => 'Ali']) // missing link
        ->build();
})->throws(RuntimeException::class, 'Missing parameters for sms.welcome: link');

it('throws if path used with token but user is not set', function (): void {
    SmsBuilder::make('sms.welcome')
        ->withToken()
        ->build();
})->throws(RuntimeException::class, 'User must be provided through the `path()` method to generate auth token.');
