<?php

namespace Database\Factories;

use App\Enums\SMSGateways;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsGatewayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'gateway' => SMSGateways::random(),
            'owner_type' => User::class,
            'owner_id' => User::factory(),
            'config' => [
                'merchant_id' => $this->faker->uuid,
                'callback_url' => $this->faker->url,
            ],
            'status' => $this->faker->boolean,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function active(): static
    {
        return $this->state(['status' => true]);
    }
}
