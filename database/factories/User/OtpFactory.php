<?php

namespace Database\Factories\User;

use App\Enums\NoticeType;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OtpFactory extends Factory
{
    protected $model = Otp::class;

    public function definition(): array
    {
        return [
            'token' => Str::random(10),
            'user_id' => User::factory(),
            'otp_code' => '5678',
            'login_id' => $this->faker->email,
            'type' => NoticeType::EMAIL,
            'used' => $this->faker->boolean,
            'attempts' => $this->faker->numberBetween(1, 5),
        ];
    }
}
