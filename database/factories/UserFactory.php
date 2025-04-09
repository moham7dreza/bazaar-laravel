<?php

namespace Database\Factories;

use App\Enums\Theme;
use App\Models\Geo\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'theme' => Theme::DRACULA->value,
            'suspended_at' => null,
            'suspended_until' => null,
            'is_active' => true,
            'user_type' => 0,
            'mobile' => $this->faker->phoneNumber,
            'mobile_verified_at' => now(),
            'city_id' => City::factory(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'mobile_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'user_type' => 1,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'suspended_at' => now(),
            'suspended_until' => now()->addWeek(),
        ]);
    }
}
