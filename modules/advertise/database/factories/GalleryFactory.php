<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Modules\Advertise\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Advertisement;

/**
 * @extends Factory<Gallery>
 */
final class GalleryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'advertisement_id' => Advertisement::factory(),
            'url'              => fake()->imageIndexArray(),
        ];
    }
}
