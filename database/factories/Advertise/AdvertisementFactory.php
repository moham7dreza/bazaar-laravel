<?php

namespace Database\Factories\Advertise;

use App\Enums\Advertisement\AdvertisementStatus;
use App\Enums\Advertisement\AdvertisementType;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\Category;
use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertise\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'description' => fake()->text,
            'ads_type' => AdvertisementType::random(),
            'ads_status' => AdvertisementStatus::random(),
            'category_id' => Category::factory(),
            'city_id' => City::factory(),
            'user_id' => User::factory(),
            'status' => true,
            'published_at' => now()->subMonth(),
            'expired_at' => now()->addYear(),
            'view' => fake()->randomNumber(),
            'contact' => fake()->phoneNumber,
            'is_special' => fake()->boolean,
            'is_ladder' => fake()->boolean,
            'image' => fake()->imageIndexArray,
            'price' => fake()->randomNumber(),
            'tags' => fake()->tags,
            'lat' => fake()->latitude,
            'lng' => fake()->longitude,
            'willing_to_trade' => fake()->boolean,
        ];
    }
}
