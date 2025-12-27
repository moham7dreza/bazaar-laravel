<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Modules\Advertise\Enums\AdvertisementPublishStatus;
use Modules\Advertise\Enums\AdvertisementStatus;
use Modules\Advertise\Enums\AdvertisementType;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Category;
use Modules\Region\Models\City;

/**
 * @extends Factory<Advertisement>
 */
final class AdvertisementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'            => persian_faker()->sentence(),
            'description'      => persian_faker()->text(),
            'ads_type'         => AdvertisementType::random(),
            'ads_status'       => AdvertisementStatus::random(),
            'category_id'      => Category::factory(),
            'city_id'          => City::factory(),
            'user_id'          => User::factory(),
            'status'           => AdvertisementPublishStatus::Active,
            'published_at'     => Date::now()->subMonth(),
            'expired_at'       => Date::now()->addYear(),
            'view'             => fake()->randomNumber(),
            'contact'          => fake()->phoneNumber(),
            'is_special'       => fake()->boolean(),
            'is_ladder'        => fake()->boolean(),
            'image'            => fake()->imageIndexArray(),
            'tags'             => fake()->tags(),
            'lat'              => fake()->latitude(),
            'lng'              => fake()->longitude(),
            'willing_to_trade' => fake()->boolean(),
        ];
    }
}
