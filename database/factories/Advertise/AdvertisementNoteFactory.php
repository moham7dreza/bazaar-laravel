<?php

namespace Database\Factories\Advertise;

use App\Models\Advertise\Advertisement;
use App\Models\Advertise\AdvertisementNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementNoteFactory extends Factory
{
    protected $model = AdvertisementNote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'advertisement_id' => Advertisement::factory(),
            'note' => $this->faker->text,
        ];
    }
}
