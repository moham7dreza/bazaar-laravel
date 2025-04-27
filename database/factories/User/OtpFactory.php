<?php

namespace Database\Factories\User;

use App\Enums\NoticeType;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Otp>
 */
class OtpFactory extends Factory
{
    protected $model = Otp::class;

    public function definition(): array
    {
        return [
            'token' => Str::random(10),
            'user_id' => User::factory(),
            'otp_code' => '5678',
            'login_id' => fake()->email,
            'type' => NoticeType::EMAIL,
            'used' => false,
            'attempts' => 1,
        ];
    }
}
