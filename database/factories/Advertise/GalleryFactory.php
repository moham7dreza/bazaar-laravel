<?php

namespace Database\Factories\Advertise;

use App\Models\Advertise\Advertisement;
use App\Models\Advertise\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertise\Gallery>
 */
class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        return [
            'advertisement_id' => Advertisement::factory(),
            'url' => fake()->imageIndexArray,
        ];
    }
}
