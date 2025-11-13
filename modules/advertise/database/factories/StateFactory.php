<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Modules\Advertise\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<State>
 */
final class StateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->name(),
            'description' => fake()->text(),
            'icon'        => 'fa fa-car',
            'parent_id'   => null,
            'status'      => true,
        ];
    }
}
