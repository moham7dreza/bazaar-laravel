<?php

declare(strict_types=1);

namespace Modules\Payment\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Advertise\Models\Advertisement;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Models\Payment;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'advertisement_id' => Advertisement::factory(),
            'amount'           => fake()->randomFloat(2, 1000, 999999),
            'description'      => fake()->realText(),
            'status'           => PaymentStatus::Pending,
            'authority'        => fake()->uuid(),
            'ref_id'           => fake()->uuid(),
            'card_pan'         => fake()->creditCardNumber(),
            'trace_no'         => fake()->uuid(),
            'gateway_response' => null,
        ];
    }
}
