<?php

declare(strict_types=1);

use Modules\Content\Models\Menu;

it('can get all parent menus', function (): void {

    $menu = Menu::factory()
        ->for(Menu::factory(), 'parent')
        ->create();

    expect($menu->parent_id)->not->toBeNull();

    $response = \Pest\Laravel\getJson(route('api.menus.index'))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    expect($data)->toHaveCount(8)
        ->id->toBe($menu->parent_id)
        ->parent_id->toBeNull()
        ->title->toBeString()
        ->url->toBeUrl()
        ->slug->toBeString()
        ->position->toBeString()
        ->status->toBeBool()
        ->icon->toBeString();

    Pest\Laravel\assertModelExists($menu);
});
