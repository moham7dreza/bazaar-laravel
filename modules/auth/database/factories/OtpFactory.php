<?php

declare(strict_types=1);

namespace Modules\Auth\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Auth\Enums\NoticeType;
use Modules\Auth\Models\Otp;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Auth\Models\Otp>
 */
final class OtpFactory extends Factory
{
    protected $model = Otp::class;

    public function definition(): array
    {
        return [
            'token'    => Str::random(10),
            'user_id'  => User::factory(),
            'otp_code' => '5678',
            'login_id' => fake()->email,
            'type'     => NoticeType::EMAIL,
            'used'     => false,
            'attempts' => 1,
        ];
    }
}
