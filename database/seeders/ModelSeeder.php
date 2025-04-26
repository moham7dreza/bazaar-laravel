<?php

namespace Database\Seeders;

use App\Enums\NoticeType;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use App\Models\Advertise\Category;
use App\Models\Advertise\CategoryAttribute;
use App\Models\Advertise\CategoryValue;
use App\Models\Advertise\Gallery;
use App\Models\Advertise\State;
use App\Models\Content\Menu;
use App\Models\Content\Page;
use App\Models\PaymentGateway;
use App\Models\SmsGateway;
use App\Models\SmsLog;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(5)->suspended()->create();
        /*
        User::factory(5)->admin()
            ->sequence(fn (Sequence $sequence) => [
                'email' => "admin@admin$sequence->index.com",
                'mobile' => "0912345656$sequence->index",
            ])
            ->create();
        */
        Otp::factory(2)
            ->sequence(
                ['type' => NoticeType::EMAIL],
                ['type' => NoticeType::SMS],
            )->create();
        Menu::factory(5)->create();
        Page::factory(5)->create();
        SmsLog::factory(5)->create();
        State::factory(5)->create();
        Category::factory()
            ->has(CategoryAttribute::factory(2)
                ->has(CategoryValue::factory(2))
            );
        Advertisement::factory(5)
            ->has(AdvertisementNote::factory(2))
            ->has(Gallery::factory(2), 'images')
            ->create();
        PaymentGateway::factory(5)->create();
        SmsGateway::factory(5)->create();
        $this->command->alert('Relations seeded');
    }
}
