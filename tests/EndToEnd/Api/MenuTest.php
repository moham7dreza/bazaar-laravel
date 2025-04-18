<?php

use App\Models\Content\Menu;

it('can get all parent menus', function () {

    $menu = Menu::factory()
        ->for(Menu::factory(), 'parent')
        ->create();

    expect($menu->parent_id)->not->toBeNull();

    $response = $this->getJson(route('menus.index'))->assertOk();

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

    $this->assertModelExists($menu);
});
