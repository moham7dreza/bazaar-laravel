<?php

use App\Models\Content\Page;

it('can get all pages', function (): void {

    $page = Page::factory()->create();

    $response = $this->getJson(route('pages.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(5)
        ->id->toBe($page->id)
        ->title->toBeString()
        ->slug->toBeString()
        ->status->toBeBool()
        ->body->toBeString();

    $this->assertModelExists($page);
});
