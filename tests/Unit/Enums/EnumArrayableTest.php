<?php

declare(strict_types=1);

use Tests\Unit\Enums\SimpleEnum;

it('can get all enum case names', function (): void {
    $names = SimpleEnum::names();

    expect($names)->toBe(['First', 'Second', 'Third']);
});

it('can get all enum values', function (): void {
    $values = SimpleEnum::values();

    expect($values)->toBe(['first', 'second', 'third']);
});

it('can convert enum to array', function (): void {
    $array = SimpleEnum::toArray();

    expect($array)->toBe([
        'first'  => 'First',
        'second' => 'Second',
        'third'  => 'Third',
    ]);
});

it('can get a random enum case', function (): void {
    $random = SimpleEnum::randomCase();

    expect($random)->toBeInstanceOf(SimpleEnum::class)
        ->and(SimpleEnum::values())->toContain($random->value);
});

it('can get a random enum value', function (): void {
    $randomValue = SimpleEnum::randomValue();

    expect(SimpleEnum::values())->toContain($randomValue);
});

it('can get random case excluding specific values', function (): void {
    $random = SimpleEnum::randomCase(SimpleEnum::First);

    expect($random)->not->toBe(SimpleEnum::First)
        ->and($random)->toBeInstanceOf(SimpleEnum::class);
});

it('can get random case excluding array of values', function (): void {
    $random = SimpleEnum::randomCase([SimpleEnum::First, SimpleEnum::Second]);

    expect($random)->toBe(SimpleEnum::Third);
});

it('can get random value excluding specific values', function (): void {
    $randomValue = SimpleEnum::randomValue([SimpleEnum::First, SimpleEnum::Second]);

    expect($randomValue)->toBe('third');
});

it('can get random case excluding string values', function (): void {
    $random = SimpleEnum::randomCase('first');

    expect($random)->not->toBe(SimpleEnum::First)
        ->and($random)->toBeInstanceOf(SimpleEnum::class);
});
