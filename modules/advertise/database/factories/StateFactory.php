<?php

declare(strict_types=1);

namespace Modules\Advertise\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\State;

/**
 * @extends Factory<State>
 */
final class StateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => persian_faker()->city(),
            'description' => persian_faker()->text(),
            'icon'        => 'fa fa-car',
            'parent_id'   => null,
            'status'      => true,
        ];
    }
}
