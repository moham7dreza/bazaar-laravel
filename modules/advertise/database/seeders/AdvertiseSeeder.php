<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;
use Modules\Advertise\Models\Category;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;
use Modules\Advertise\Models\Gallery;
use Modules\Advertise\Models\State;

final class AdvertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();

        // State
        $parentStates = State::factory(5)->create();
        State::factory(5)
            ->for($parentStates->random()->first(), 'parent')
            ->create();

        // Ad
        $parentCategories = Category::factory(5)
            ->has(CategoryAttribute::factory(2)->has(CategoryValue::factory(2)), 'attributes')
            ->create();

        Category::factory()
            ->for($parentCategories->random()->first(), 'parent')
            ->create();

        Advertisement::factory(5)
            ->for($parentCategories->random()->first())
            ->has(AdvertisementNote::factory(2))
            ->has(Gallery::factory(2), 'images')
            ->hasAttached($users->random(2), relationship: 'favoritedByUsers')
            ->hasAttached($users->random(2), relationship: 'viewedByUsers')
            ->hasAttached(CategoryValue::factory(2)->create(), relationship: 'categoryValues')
            ->create();
    }
}
