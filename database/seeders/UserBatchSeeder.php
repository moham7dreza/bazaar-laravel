<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\Advertise\Database\Seeders\AdvertisementBatchSeeder;
use Modules\Advertise\Models\Advertisement;

final class UserBatchSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::query()->truncate();
        Advertisement::query()->truncate();

        $totalUsers = 1000;

        $password = Hash::make('password');

        $batchSize = round($totalUsers / 100);

        for ($times = 0; $times < 10; $times++)
        {
            $offset = $times * $batchSize * 10;

            // process in smaller batches to avoid memory issues
            for ($batch = 0; $batch < 10; $batch++)
            {
                $users   = [];
                $startId = ($batch * $batchSize) + 1;
                $endId   = ($batch + 1) * $batchSize;

                for ($i = $startId; $i <= $endId; $i++)
                {
                    $users[] = [
                        'id'         => (int) ($i + $offset),
                        'name'       => fake()->name(),
                        'email'      => fake()->userName() . ($i + $offset) . '@' . fake()->safeEmailDomain(),
                        'mobile'     => '09' . fake()->randomNumber(9),
                        'password'   => $password,
                        'created_at' => Date::now()->toDateTimeString(),
                        'updated_at' => Date::now()->toDateTimeString(),
                    ];
                }

                // insert in chunks of 1000
                foreach (array_chunk($users, 1000) as $chunk)
                {
                    User::query()->insert($chunk);

                    app(AdvertisementBatchSeeder::class)->createAdsForUsers($chunk);
                }

                // free memory between batches
                unset($users);
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->command->info('Users batch successfully inserted');
    }
}
