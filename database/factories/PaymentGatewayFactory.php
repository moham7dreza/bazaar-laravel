<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PaymentGateways;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentGateway>
 */
class PaymentGatewayFactory extends Factory
{
    protected $model = PaymentGateway::class;

    public function definition(): array
    {
        return [
            'gateway'    => PaymentGateways::random(),
            'owner_type' => fake()->randomElement([User::class]),
            'owner_id'   => function (array $attributes) {
                return match ($attributes['owner_type'])
                {
                    User::class => UserFactory::new()->create()->id,
                };
            },
            'config' => [
                'merchant_id'  => fake()->uuid,
                'callback_url' => fake()->url,
            ],
            'status'     => fake()->boolean,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }

    public function active(): static
    {
        return $this->state(['status' => true]);
    }
}
