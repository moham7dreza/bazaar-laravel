<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Seeders;

use App\Models\Geo\City;
use App\Models\User;
use Exception;
use Illuminate\Container\Attributes\Context;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Modules\Advertise\Enums\AdvertisementStatus;
use Modules\Advertise\Enums\AdvertisementType;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Category;

class AdvertisementBatchSeeder extends Seeder
{
    public function run(
        #[Context('users')]
        ?Collection $users,
    ): void {

        if ( ! $users)
        {
            $users = collect(User::all()->modelKeys());
            if ($users->isEmpty())
            {
                $users = User::factory(5)->create();
            }
        }
        $this->createAdsForUsers($users->toArray());
    }

    public function createAdsForUsers(array $users): void
    {
        $adsPerUser = 100;
        $chunkSize  = 50;
        $ads        = [];

        $categories = Category::factory($adsPerUser)->make();
        $categories->chunk($chunkSize)->each(fn (Collection $categories) => Category::query()->insert($categories->toArray()));

        $cities = City::factory($adsPerUser)->make();
        $cities->chunk($chunkSize)->each(fn (Collection $cities) => City::query()->insert($cities->toArray()));

        $maxAdId = DB::table('advertisements')->max('id') ?? 0;
        $adId    = $maxAdId + 1;

        foreach ($users as $user)
        {
            $userId = Arr::get($user, 'id');
            $this->command->info("user {$userId} is processing");
            // need for check ad depth
            //            $userAdIds = [];

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

                $categoryId = $categories->random()->first()->id;
                $cityId     = $cities->random()->first()->id;

                if ( ! $categoryId || ! $cityId)
                {
                    continue;
                }

                $ads[] = [
                    'id'           => $adId,
                    'title'        => fake()->jobTitle(),
                    'slug'         => fake()->slug(),
                    'description'  => fake()->text(),
                    'ads_type'     => fake()->randomElement(AdvertisementType::cases()),
                    'ads_status'   => fake()->randomElement(AdvertisementStatus::cases()),
                    'category_id'  => $categoryId,
                    'city_id'      => $cityId,
                    'user_id'      => $userId,
                    'status'       => true,
                    'published_at' => fake()->dateTimeBetween('now', '+2 months'),
                    'expired_at'   => fake()->boolean(40) ? fake()->dateTimeBetween('+2 months', '+4 months') : null,
                    'contact'      => fake()->phoneNumber(),
                    'image'        => fake()->imageUrl(200, 200, 'people'),
                    'price'        => fake()->randomFloat(2, 10),
                    'tags'         => fake()->tags(),
                    'lat'          => fake()->latitude(),
                    'lng'          => fake()->longitude(),
                    'created_at'   => Date::now()->toDateTimeString(),
                    'updated_at'   => Date::now()->toDateTimeString(),
                ];

                $this->command->info("ads {$adId} is processing");

                //                $userAdIds[$adId] = $adId;
                $adId++;
            }

            //            unset($userAdIds);
        }

        $adsToBeInserts = count($ads);
        $this->command->info("total {$adsToBeInserts} ads should be processed");

        // insert in chunks of 5000
        foreach (array_chunk($ads, 5000) as $chunk)
        {
            $this->command->info('chunk is processing');
            try
            {
                Advertisement::query()->insert($chunk);
            } catch (Exception $e)
            {
                $this->command->error($e->getMessage());
            }
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
