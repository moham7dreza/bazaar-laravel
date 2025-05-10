<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Advertise\Models\State>
 */
final class StateFactory extends Factory
{
    protected $model = State::class;

    public function definition(): array
    {
        return [
            'name'        => fake()->name,
            'description' => fake()->text,
            'icon'        => 'fa fa-car',
            'parent_id'   => null,
            'status'      => true,
        ];
    }
}
