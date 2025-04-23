<?php

use App\Models\Content\Menu;

it('can load all child menus', function () {

    $menu = Menu::factory()
        ->for(Menu::factory()
            ->for(Menu::factory()
                ->for(Menu::factory(), 'parent'),
                'parent'),
            'parent')
        ->create();

    $menus = Menu::query()->loadChildren()->count();

    expect($menus)->toBe(4);
});
