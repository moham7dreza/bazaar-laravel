<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Tests\Unit\Enums\TestStatusEnum;

beforeEach(function (): void {
    // Set default locale for tests
    App::setLocale('en');
});

it('can get translation key for enum', function (): void {
    $key = TestStatusEnum::getTransKey();

    expect($key)->toBe('enums.test_statuses');
});

it('can get translation key for enum case', function (): void {
    $enum = TestStatusEnum::Draft;
    $key  = $enum->transKey();

    expect($key)->toBe('enums.test_statuses.draft');
});

it('can translate enum value in current locale', function (): void {
    App::setLocale('en');
    $enum = TestStatusEnum::Draft;

    expect($enum->trans())->toBe('Draft');
});

it('can translate enum value in specific locale', function (): void {
    $enum = TestStatusEnum::Draft;

    expect($enum->trans('en'))->toBe('Draft');
});

it('can get all translations for enum case', function (): void {
    $enum            = TestStatusEnum::Draft;
    $allTranslations = $enum->allTrans();

    expect($allTranslations)->toBe([
        'fa' => 'پیش نویس',
        'en' => 'Draft',
    ]);
});

it('can get enum as object with value and translated name', function (): void {
    App::setLocale('en');
    $enum   = TestStatusEnum::Draft;
    $object = $enum->object();

    expect($object)->toBe([
        'value' => 'draft',
        'name'  => 'Draft',
    ]);
});

it('can get all enum options as array with id and name', function (): void {
    App::setLocale('en');
    $options = TestStatusEnum::toArrayTrans();

    expect($options)->toBe([
        ['value' => 'draft', 'name' => 'Draft'],
        ['value' => 'pending', 'name' => 'Pending'],
        ['value' => 'published', 'name' => 'Published'],
    ]);
});

it('returns translated names based on current locale', function (): void {
    App::setLocale('fa');
    $options = TestStatusEnum::toArrayTrans();

    expect($options)->toBe([
        ['value' => 'draft', 'name' => 'پیش نویس'],
        ['value' => 'pending', 'name' => 'در انتظار'],
        ['value' => 'published', 'name' => 'منتشر شده'],
    ]);
});

it('can get object with translated name in different locale', function (): void {
    $enum = TestStatusEnum::Pending;

    App::setLocale('en');
    expect(Arr::get($enum->object(), 'name'))->toBe('Pending');

    App::setLocale('fa');
    expect(Arr::get($enum->object(), 'name'))->toBe('در انتظار');
});

it('can get all translations for all enum cases', function (): void {
    $draft     = TestStatusEnum::Draft;
    $pending   = TestStatusEnum::Pending;
    $published = TestStatusEnum::Published;

    expect($draft->allTrans())->toBe([
        'fa' => 'پیش نویس',
        'en' => 'Draft',
    ])
        ->and($pending->allTrans())->toBe([
            'fa' => 'در انتظار',
            'en' => 'Pending',
        ])
        ->and($published->allTrans())->toBe([
            'fa' => 'منتشر شده',
            'en' => 'Published',
        ]);
});
