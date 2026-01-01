<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Seeders;

use App\Models\Attribute;
use Illuminate\Container\Attributes\Context;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;
use Modules\Advertise\Models\AdvertisementPrice;
use Modules\Advertise\Models\Category;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;
use Modules\Advertise\Models\Gallery;
use Modules\Advertise\Models\State;

final class AdvertisementSeeder extends Seeder
{
    public function run(
        #[Context('users')]
        Collection $users,
    ): void {
        // State
        $parentStates = State::factory(5)->create();
        State::factory(5)
            ->for($parentStates->random()->first(), 'parent')
            ->insert();

        // Ad
        $parentCategories = Category::factory(5)
            ->has(CategoryAttribute::factory(2)->has(CategoryValue::factory(2)), 'attributes')
            ->create();

        Category::factory()
            ->for($parentCategories->random()->first(), 'parent')
            ->insert();

        Advertisement::factory(12)
            ->for($parentCategories->random()->first())
            ->has(AdvertisementNote::factory(2))
            ->has(Gallery::factory(2), 'images')
            ->hasAttached($users->random(2), relationship: 'favoritedByUsers')
            ->hasAttached($users->random(2), relationship: 'viewedByUsers')
            ->hasAttached(CategoryValue::factory(2)->create(), relationship: 'categoryValues')
            ->has(AdvertisementPrice::factory(), 'prices')
            ->has(Attribute::factory(3))
            ->create();
    }
}
