<?php

declare(strict_types=1);

namespace Modules\Auth\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Auth\Enums\NoticeType;
use Modules\Auth\Models\Otp;
use Random\RandomException;

/**
 * @extends Factory<Otp>
 */
final class OtpFactory extends Factory
{
    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'token'    => Str::random(10),
            'user_id'  => User::factory(),
            'otp_code' => random_int(1000, 9999),
            'login_id' => fake()->email(),
            'type'     => NoticeType::Email,
            'used'     => false,
            'attempts' => 1,
        ];
    }
}
