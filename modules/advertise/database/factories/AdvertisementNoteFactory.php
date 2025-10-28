<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Advertisement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\AdvertisementNote>
 */
final class AdvertisementNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'advertisement_id' => Advertisement::factory(),
            'note'             => fake()->text,
        ];
    }
}
