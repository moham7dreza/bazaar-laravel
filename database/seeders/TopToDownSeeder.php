<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\NoticeType;
use App\Models\Content\Menu;
use App\Models\Content\Page;
use App\Models\Holiday;
use App\Models\PaymentGateway;
use App\Models\SmsGateway;
use App\Models\SmsLog;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;
use Modules\Advertise\Models\Category;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;
use Modules\Advertise\Models\Gallery;
use Modules\Advertise\Models\State;

final class TopToDownSeeder extends Seeder
{
    public function run(): void
    {
        // User
        User::factory(5)->suspended()->create();
        $users = User::factory(5)->create();
        /*
        User::factory(5)->admin()
            ->sequence(fn (Sequence $sequence) => [
                'email' => "admin@admin$sequence->index.com",
                'mobile' => "0912345656$sequence->index",
            ])
            ->create();
        */
        Otp::factory(2)
            ->for($users->random()->first())
            ->sequence(
                ['type' => NoticeType::EMAIL],
                ['type' => NoticeType::SMS],
            )->create();

        SmsLog::factory(5)
            ->for($users->random()->first())
            ->create();

        // Menu
        $parentMenus = Menu::factory(5)->create();
        Menu::factory(5)
            ->for($parentMenus->random()->first(), 'parent')
            ->create();

        // Page
        Page::factory(5)->create();

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

        // Gateway
        PaymentGateway::factory(5)->create();
        SmsGateway::factory(5)->create();

        // days
        Holiday::factory(5)->create();

        $this->command->alert('Relations seeded');
    }
}
