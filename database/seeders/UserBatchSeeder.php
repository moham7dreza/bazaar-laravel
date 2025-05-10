<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Advertisement\AdvertisementStatus;
use App\Enums\Advertisement\AdvertisementType;
use App\Models\Geo\City;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Database\Seeder;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Category;
use Schema;

final class UserBatchSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Advertisement::truncate();

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
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }

                // insert in chunks of 1000
                foreach (array_chunk($users, 1000) as $chunk)
                {
                    User::insert($chunk);

                    $this->createAdsForUsers($chunk);
                }

                // free memory between batches
                unset($users);
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->command->info('Users batch successfully inserted');
    }

    private function createAdsForUsers(array $users): void
    {
        $adsPerUser = 20;
        $ads        = [];

        $categories = Category::factory($adsPerUser)->create();
        $cities     = City::factory($adsPerUser)->create();

        $maxAdId = DB::table('advertisements')->max('id') ?? 0;
        $adId    = $maxAdId + 1;

        foreach ($users as $user)
        {
            $userId = $user['id'];
            // need for check ad depth
            $userAdIds = [];

            for ($i = 1; $i <= $adsPerUser; $i++)
            {
//                $adDepth = 0;
//                $parentId = null;
//
//                // determine if this should be a child ad (max 4 levels deep)
//                if ($i > 1 && count($userAdIds) > 0 && fake()->boolean(4)) {
//                    $parentId = fake()->randomElement($userAdIds);
//
//                    $adDepth = $this->getAdDepth($parentId, $userAdIds);
//
//                    if ($adDepth >= 4) {
//                        $parentId = null;
//                    }
//                }

                $ads[] = [
                    'id'           => $adId,
                    'title'        => fake()->jobTitle(),
                    'slug'         => fake()->slug(),
                    'description'  => fake()->text(),
                    'ads_type'     => fake()->randomElement(AdvertisementType::cases()),
                    'ads_status'   => fake()->randomElement(AdvertisementStatus::cases()),
                    'category_id'  => $categories->random()->id,
                    'city_id'      => $cities->random()->id,
                    'user_id'      => $userId,
                    'status'       => true,
                    'published_at' => fake()->dateTimeBetween('now', '+2 months'),
                    'expired_at'   => fake()->boolean(40) ? fake()->dateTimeBetween('+2 months', '+4 months') : null,
                    'contact'      => fake()->phoneNumber(),
                    'image'        => fake()->imageUrl(),
                    'price'        => fake()->randomFloat(2, 10),
                    'tags'         => fake()->tags(),
                    'lat'          => fake()->latitude(),
                    'lng'          => fake()->longitude(),
                    'created_at'   => now()->toDateTimeString(),
                    'updated_at'   => now()->toDateTimeString(),
                ];

                $userAdIds[$adId] = $adId;
                $adId++;
            }

            unset($userAdIds);
        }

        // insert in chunks of 5000
        foreach (array_chunk($ads, 5000) as $chunk)
        {
            Advertisement::insert($chunk);
        }

        // free memory between batches
        unset($ads);
    }

    private function getAdDepth(int $adId, array $userAdIds): int
    {
        $depth      = 1;
        $currentId  = $adId;
        $maxDepth   = 10; // safety to prevent infinite loops
        $depthCount = 0;

        while ($depthCount < $maxDepth)
        {
            $depthCount++;

            $ad = DB::table('advertisements')->where('id', $currentId)->first();

            if ($ad && $ad->parent_id)
            {
                $depth++;
                $currentId = $ad->parent_id;
            } else
            {
                break;
            }
        }

        return $depth;
    }
}
