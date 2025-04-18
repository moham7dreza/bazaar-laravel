<?php

namespace Database\Factories\Advertise;

use App\Enums\AdvertisementStatus;
use App\Enums\AdvertisementType;
use App\Models\Advertise\Advertisement;
use App\Models\Advertise\Category;
use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'ads_type' => AdvertisementType::random(),
            'ads_status' => AdvertisementStatus::random(),
            'category_id' => Category::factory(),
            'city_id' => City::factory(),
            'user_id' => User::factory(),
            'status' => true,
            'published_at' => now()->addMonth(),
            'expired_at' => now()->addYear(),
            'view' => $this->faker->randomNumber(),
            'contact' => $this->faker->phoneNumber,
            'is_special' => $this->faker->boolean,
            'is_ladder' => $this->faker->boolean,
            'image' => $this->faker->imageIndexArray,
            'price' => $this->faker->randomNumber(),
            'tags' => $this->faker->tags,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'willing_to_trade' => $this->faker->boolean,
        ];
    }
}
