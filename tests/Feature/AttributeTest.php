<?php

declare(strict_types=1);

use Modules\Advertise\Models\Advertisement;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertNotEmpty;

beforeEach(function (): void {
    $this->advertise = Advertisement::factory()->create([
        'title' => 'test-ad',
    ]);
});

test('test can attach attributes to model', function (): void {

    $this->advertise->attachAttribute($title = 'name', $value = 'implicit value');

    assertDatabaseCount('advertisements', 1);
    assertDatabaseHas('advertisements', [
        'title' => 'test-ad',
    ]);

    assertDatabaseCount('attributes', 1);
    assertDatabaseHas('attributes', [
        'title' => $title,
        'value' => $value,
    ]);

    expect($this->advertise->hasAttributeValue($value))
        ->toBeTrue()
        ->and($this->advertise->hasAttributeTitle($title))
        ->toBeTrue();
});

test('test can attach multiple attributes to model', function (): void {
    $this->advertise->attachAttributes([
        [
            'title' => 'test',
            'value' => 'developer',
        ],
        [
            'title' => 'framework',
            'value' => 'laravel',
        ],
    ]);

    assertDatabaseCount('advertisements', 1);
    assertDatabaseHas('advertisements', [
        'title' => 'test-ad',
    ]);

    assertDatabaseCount('attributes', 2);
    assertDatabaseHas('attributes', [
        'title' => 'test',
        'value' => 'developer',
    ]);
    assertDatabaseHas('attributes', [
        'title' => 'framework',
        'value' => 'laravel',
    ]);

    expect($this->advertise->hasAttributeValue('developer'))
        ->toBeTrue()
        ->and($this->advertise->hasAttributeTitle('test'))
        ->toBeTrue()
        ->and($this->advertise->hasAttributeValue('laravel'))
        ->toBeTrue()
        ->and($this->advertise->hasAttributeTitle('framework'))
        ->toBeTrue();
});

test('test attributes can retrieve in model relation', function (): void {
    $ad = Advertisement::query()->with('attributes')->first();

    assertEmpty($ad->attributes()->get());

    $ad->attachAttribute('test', 'developer');
    assertNotEmpty($ad->attributes()->get());
});

test('test product has attribute value', function (): void {
    $this->advertise->attachAttribute('role', $value = 'developer');

    assertDatabaseCount('advertisements', 1);
    assertDatabaseCount('attributes', 1);
    assertNotEmpty($this->advertise->hasAttributeValue($value));
});

test('test product has attribute title', function (): void {
    $this->advertise->attachAttribute($title = 'role', 'developer');

    assertDatabaseCount('advertisements', 1);
    assertDatabaseCount('attributes', 1);
    assertNotEmpty($this->advertise->hasAttributeTitle($title));
});

test('test can attribute delete from model', function (): void {
    $this->advertise->attachAttribute($title = 'role', $value = 'developer');
    $this->advertise->deleteAttribute($title, $value);

    assertDatabaseCount('advertisements', 1);
    assertDatabaseCount('attributes', 0);
});

test('test can delete all attributes of one model', function (): void {
    $this->advertise->attachAttribute('role', 'developer');
    $this->advertise->attachAttribute('stack', 'laravel');
    $this->advertise->deleteAllAttributes();

    assertDatabaseCount('advertisements', 1);
    assertDatabaseCount('attributes', 0);
});

test('test can delete attribute by title', function (): void {
    $this->advertise->attachAttribute('role', 'developer');
    $this->advertise->deleteAttributeByTitle('role');

    assertDatabaseCount('advertisements', 1);
    assertDatabaseCount('attributes', 0);
    assertDatabaseMissing('attributes', ['title' => 'role']);
});

test('test can delete attribute by value', function (): void {
    $this->advertise->attachAttribute('role', 'developer');
    $this->advertise->deleteAttributeByValue('developer');

    assertDatabaseCount('advertisements', 1);
    assertDatabaseCount('attributes', 0);
    assertDatabaseMissing('attributes', ['value' => 'developer']);
});
