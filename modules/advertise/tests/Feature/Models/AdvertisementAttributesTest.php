<?php

declare(strict_types=1);

use Modules\Advertise\Models\Advertisement;

it('can attach and retrieve custom attributes', function (): void {
    $advertisement = Advertisement::factory()->create();

    expect($advertisement)->toBeInstanceOf(Advertisement::class);
    expect(method_exists($advertisement, 'customAttributes'))->toBeTrue();

    // Attach a custom attribute
    $advertisement->attachAttribute('color', 'red');

    // Retrieve custom attributes
    $attributes = $advertisement->customAttributes()->get();

    expect($attributes)->toHaveCount(1);
    expect($attributes->first()->title)->toBe('color');
    expect($attributes->first()->value)->toBe('red');
});

it('can attach multiple custom attributes', function (): void {
    $advertisement = Advertisement::factory()->create();

    // Attach multiple attributes
    $advertisement->attachAttributes([
        ['title' => 'size', 'value' => 'large'],
        ['title' => 'condition', 'value' => 'new'],
    ]);

    $attributes = $advertisement->customAttributes()->get();

    expect($attributes)->toHaveCount(2);
    expect($attributes->pluck('title')->toArray())->toContain('size', 'condition');
});

it('can check if has attribute value', function (): void {
    $advertisement = Advertisement::factory()->create();
    $advertisement->attachAttribute('brand', 'Nike');

    expect($advertisement->hasAttributeValue('Nike'))->toBeTrue();
    expect($advertisement->hasAttributeValue('Adidas'))->toBeFalse();
});

it('can check if has attribute title', function (): void {
    $advertisement = Advertisement::factory()->create();
    $advertisement->attachAttribute('brand', 'Nike');

    expect($advertisement->hasAttributeTitle('brand'))->toBeTrue();
    expect($advertisement->hasAttributeTitle('model'))->toBeFalse();
});

it('can delete attribute by title', function (): void {
    $advertisement = Advertisement::factory()->create();
    $advertisement->attachAttribute('color', 'blue');
    $advertisement->attachAttribute('size', 'medium');

    expect($advertisement->customAttributes()->count())->toBe(2);

    $advertisement->deleteAttributeByTitle('color');

    expect($advertisement->customAttributes()->count())->toBe(1);
    expect($advertisement->hasAttributeTitle('color'))->toBeFalse();
    expect($advertisement->hasAttributeTitle('size'))->toBeTrue();
});

it('can delete attribute by value', function (): void {
    $advertisement = Advertisement::factory()->create();
    $advertisement->attachAttribute('color', 'blue');
    $advertisement->attachAttribute('brand', 'blue');

    expect($advertisement->customAttributes()->count())->toBe(2);

    $advertisement->deleteAttributeByValue('blue');

    expect($advertisement->customAttributes()->count())->toBe(0);
});

it('can delete all attributes', function (): void {
    $advertisement = Advertisement::factory()->create();
    $advertisement->attachAttribute('color', 'red');
    $advertisement->attachAttribute('size', 'large');
    $advertisement->attachAttribute('condition', 'new');

    expect($advertisement->customAttributes()->count())->toBe(3);

    $advertisement->deleteAllAttribute();

    expect($advertisement->customAttributes()->count())->toBe(0);
});
