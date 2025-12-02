<?php

declare(strict_types=1);

use Tests\Unit\Enums\SimpleEnum;

it('can get all enum case names', function (): void {
    $names = SimpleEnum::names();

    expect($names)->toBe(['FIRST', 'SECOND', 'THIRD']);
});

it('can get all enum values', function (): void {
    $values = SimpleEnum::values();

    expect($values)->toBe(['first', 'second', 'third']);
});

it('can convert enum to array', function (): void {
    $array = SimpleEnum::toArray();

    expect($array)->toBe([
        'first'  => 'FIRST',
        'second' => 'SECOND',
        'third'  => 'THIRD',
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
    $random = SimpleEnum::randomCase(SimpleEnum::FIRST);

    expect($random)->not->toBe(SimpleEnum::FIRST)
        ->and($random)->toBeInstanceOf(SimpleEnum::class);
});

it('can get random case excluding array of values', function (): void {
    $random = SimpleEnum::randomCase([SimpleEnum::FIRST, SimpleEnum::SECOND]);

    expect($random)->toBe(SimpleEnum::THIRD);
});

it('can get random value excluding specific values', function (): void {
    $randomValue = SimpleEnum::randomValue([SimpleEnum::FIRST, SimpleEnum::SECOND]);

    expect($randomValue)->toBe('third');
});

it('can get random case excluding string values', function (): void {
    $random = SimpleEnum::randomCase('first');

    expect($random)->not->toBe(SimpleEnum::FIRST)
        ->and($random)->toBeInstanceOf(SimpleEnum::class);
});
