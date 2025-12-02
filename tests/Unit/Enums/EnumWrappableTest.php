<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use ValueError;

it('can wrap an enum instance', function (): void {
    $enum    = SimpleEnum::FIRST;
    $wrapped = SimpleEnum::wrap($enum);

    expect($wrapped)->toBe($enum)
        ->and($wrapped)->toBeInstanceOf(SimpleEnum::class);
});

it('can wrap a string value to enum', function (): void {
    $wrapped = SimpleEnum::wrap('first');

    expect($wrapped)->toBe(SimpleEnum::FIRST)
        ->and($wrapped)->toBeInstanceOf(SimpleEnum::class);
});

it('returns null when wrapping null value', function (): void {
    $wrapped = SimpleEnum::wrap(null);

    expect($wrapped)->toBeNull();
});

it('returns null when wrapping empty string', function (): void {
    $wrapped = SimpleEnum::wrap('');

    expect($wrapped)->toBeNull();
});

it('throws exception when wrapping invalid value in strict mode', function (): void {
    expect(fn () => SimpleEnum::wrap('invalid', true))
        ->toThrow(ValueError::class);
});

it('returns null when wrapping invalid value in non-strict mode', function (): void {
    $wrapped = SimpleEnum::wrap('invalid', false);

    expect($wrapped)->toBeNull();
});
