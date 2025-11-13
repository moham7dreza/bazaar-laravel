<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\UserActionTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserActionTag>
 */
class UserActionTagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'action_tag' => fake()->random_array(),
        ];
    }
}
