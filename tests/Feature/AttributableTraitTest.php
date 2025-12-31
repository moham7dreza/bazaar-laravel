<?php

declare(strict_types=1);

use Modules\Advertise\Models\Advertisement;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    $this->advertisement = Advertisement::factory()->create();
});

it('can attach a single attribute', function (): void {
    $attribute = $this->advertisement->attachAttribute('color', 'red');

    expect($attribute)->not->toBeNull()
        ->and($attribute->title)->toBe('color')
        ->and($attribute->value)->toBe('red')
        ->and($attribute->attributable_id)->toBe($this->advertisement->id)
        ->and($attribute->attributable_type)->toBe('advertisement'); // morph map key

    assertDatabaseHas('attributes', [
        'title'             => 'color',
        'value'             => 'red',
        'attributable_id'   => $this->advertisement->id,
        'attributable_type' => 'advertisement', // morph map key
    ]);
});

it('can attach multiple attributes', function (): void {
    $this->advertisement->attachAttributes([
        ['title' => 'color', 'value' => 'blue'],
        ['title' => 'size', 'value' => 'large'],
    ]);

    expect($this->advertisement->attributes()->count())->toBe(2);
});

it('can retrieve attributes relationship', function (): void {
    $this->advertisement->attachAttribute('brand', 'Nike');
    $this->advertisement->attachAttribute('condition', 'new');

    // Reload the attributes relationship
    $this->advertisement->unsetRelation('attributes');

    expect($this->advertisement->attributes)->toHaveCount(2)
        ->and($this->advertisement->attributes->pluck('title')->toArray())->toContain('brand', 'condition');
});

it('can check if attribute has specific value', function (): void {
    $this->advertisement->attachAttribute('color', 'green');

    expect($this->advertisement->hasAttributeValue('green'))->toBeTrue()
        ->and($this->advertisement->hasAttributeValue('yellow'))->toBeFalse();
});

it('can check if attribute has specific title', function (): void {
    $this->advertisement->attachAttribute('material', 'cotton');

    expect($this->advertisement->hasAttributeTitle('material'))->toBeTrue()
        ->and($this->advertisement->hasAttributeTitle('nonexistent'))->toBeFalse();
});

it('can delete attribute by title', function (): void {
    $this->advertisement->attachAttribute('weight', '2kg');
    $this->advertisement->attachAttribute('color', 'black');

    $deleted = $this->advertisement->deleteAttributeByTitle('weight');

    expect($deleted)->toBe(1)
        ->and($this->advertisement->attributes()->count())->toBe(1);
});

it('can delete attribute by value', function (): void {
    $this->advertisement->attachAttribute('style', 'modern');
    $this->advertisement->attachAttribute('style', 'classic');

    $deleted = $this->advertisement->deleteAttributeByValue('modern');

    expect($deleted)->toBe(1)
        ->and($this->advertisement->attributes()->count())->toBe(1);
});

it('can delete specific attribute by title and value', function (): void {
    $this->advertisement->attachAttribute('type', 'digital');
    $this->advertisement->attachAttribute('type', 'physical');

    $deleted = $this->advertisement->deleteAttribute('type', 'digital');

    expect($deleted)->toBe(1)
        ->and($this->advertisement->attributes()->count())->toBe(1)
        ->and($this->advertisement->attributes()->first()->value)->toBe('physical');
});

it('can delete all attributes', function (): void {
    $this->advertisement->attachAttributes([
        ['title' => 'attr1', 'value' => 'val1'],
        ['title' => 'attr2', 'value' => 'val2'],
        ['title' => 'attr3', 'value' => 'val3'],
    ]);

    $this->advertisement->deleteAllAttribute();

    // Unset the cached relationship to force reload
    $this->advertisement->unsetRelation('attributes');

    expect($this->advertisement->attributes()->count())->toBe(0);
});
