<?php

namespace Database\Factories;

use App\Enums\PaymentGateways;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentGatewayFactory extends Factory
{
    protected $model = PaymentGateway::class;

    public function definition(): array
    {
        return [
            'gateway' => PaymentGateways::random(),
            'owner_type' => $this->faker->randomElement([User::class]),
            'owner_id' => function (array $attributes) {
                return match ($attributes['owner_type']) {
                    User::class => UserFactory::new()->create()->id,
                };
            },
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
