<?php

declare(strict_types=1);

namespace Modules\Content\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Content\Models\Menu;
use Modules\Content\Models\Page;

final class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Menu
        $parentMenus = Menu::factory(5)->create();
        Menu::factory(5)
            ->for($parentMenus->random()->first(), 'parent')
            ->create();

        // Page
        Page::factory(5)->create();

        $this->command->alert('Relations seeded');
    }
}
