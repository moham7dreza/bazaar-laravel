<?php

namespace Database\Factories;

use App\Enums\NoticeType;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtpFactory extends Factory
{
    protected $model = Otp::class;

    public function definition(): array
    {
        return [
            'token' => $this->faker->linuxPlatformToken,
            'user_id' => User::factory(),
            'otp_code' => '5678',
            'login_id' => $this->faker->email,
            'type' => NoticeType::EMAIL,
            'used' => $this->faker->boolean,
            'attempts' => $this->faker->randomNumber(),
        ];
    }
}
