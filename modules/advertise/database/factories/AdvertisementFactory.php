<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Enums\AdvertisementStatus;
use Modules\Advertise\Enums\AdvertisementType;
use Modules\Advertise\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\Advertisement>
 */
final class AdvertisementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'            => fake()->title(),
            'description'      => fake()->text(),
            'ads_type'         => AdvertisementType::random(),
            'ads_status'       => AdvertisementStatus::random(),
            'category_id'      => Category::factory(),
            'city_id'          => City::factory(),
            'user_id'          => User::factory(),
            'status'           => true,
            'published_at'     => now()->subMonth(),
            'expired_at'       => now()->addYear(),
            'view'             => fake()->randomNumber(),
            'contact'          => fake()->phoneNumber(),
            'is_special'       => fake()->boolean(),
            'is_ladder'        => fake()->boolean(),
            'image'            => fake()->imageIndexArray(),
            'price'            => fake()->randomNumber(),
            'tags'             => fake()->tags(),
            'lat'              => fake()->latitude(),
            'lng'              => fake()->longitude(),
            'willing_to_trade' => fake()->boolean(),
        ];
    }
}
