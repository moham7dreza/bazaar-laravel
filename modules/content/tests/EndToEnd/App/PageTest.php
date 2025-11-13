<?php

declare(strict_types=1);

use Modules\Content\Models\Page;

use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\getJson;

it('can get all pages', function (): void {

    $page = Page::factory()->create();

    $response = getJson(route('api.pages.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(5)
        ->id->toBe($page->id)
        ->title->toBeString()
        ->slug->toBeString()
        ->status->toBeBool()
        ->body->toBeString();

    assertModelExists($page);
});
