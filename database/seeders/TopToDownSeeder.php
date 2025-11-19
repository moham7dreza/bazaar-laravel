<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Classes\ContextItem;
use App\Models\Geo\City;
use App\Models\Holiday;
use App\Models\PaymentGateway;
use App\Models\SmsGateway;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Database\Seeder;

final class TopToDownSeeder extends Seeder
{
    public function run(
        //        #[Context('admin', hidden: true)]
        //        User $admin,
    ): void {
        // User
        User::factory(5)->suspended()->insert();
        $users = User::factory(5)->create();
        context()->add(ContextItem::Users, $users);
        /*
        User::factory(5)->admin()
            ->sequence(fn (Sequence $sequence) => [
                'email' => "admin@admin$sequence->index.com",
                'mobile' => "0912345656$sequence->index",
            ])
            ->insert();
        */

        SmsLog::factory(5)
            ->for($users->random()->first())
            ->insert();

        // Gateway
        PaymentGateway::factory(5)->insert();
        SmsGateway::factory(5)->insert();

        // days
        Holiday::factory(5)->insert();

        // geo
        City::factory(5)->insert();

        $this->command->alert('Relations seeded');
    }
}
