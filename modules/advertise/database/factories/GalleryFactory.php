<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Gallery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\Gallery>
 */
final class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        return [
            'advertisement_id' => Advertisement::factory(),
            'url'              => fake()->imageIndexArray,
        ];
    }
}
