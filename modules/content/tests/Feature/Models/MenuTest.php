<?php

declare(strict_types=1);

use Modules\Content\Models\Menu;

it('can load all child menus', function (): void {

    $menu = Menu::factory()
        ->for(
            Menu::factory()
                ->for(
                    Menu::factory()
                        ->for(Menu::factory(), 'parent'),
                    'parent'
                ),
            'parent'
        )
        ->create();

    $menus = Menu::query()->loadChildren()->count();

    expect($menus)->toBe(4);

    $menu->update(['title' => 'test menu']);

    expect($menu->getChanges())->toBe(['title' => 'test menu']);
});
