<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Geo\City;
use App\Models\Holiday;
use App\Models\PaymentGateway;
use App\Models\SmsGateway;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Container\Attributes\Context;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

final class TopToDownSeeder extends Seeder
{
    public function run(
        //        #[Context('admin', hidden: true)]
        //        User $admin,
    ): void {
        // User
        User::factory(5)->suspended()->create();
        $users = User::factory(5)->create();
        context()->add('users', $users);
        /*
        User::factory(5)->admin()
            ->sequence(fn (Sequence $sequence) => [
                'email' => "admin@admin$sequence->index.com",
                'mobile' => "0912345656$sequence->index",
            ])
            ->create();
        */

        SmsLog::factory(5)
            ->for($users->random()->first())
            ->create();

        // Gateway
        PaymentGateway::factory(5)->create();
        SmsGateway::factory(5)->create();

        // days
        Holiday::factory(5)->create();

        // geo
        City::factory(5)->create();

        $this->command->alert('Relations seeded');
    }
}
