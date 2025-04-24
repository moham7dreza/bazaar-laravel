<?php

namespace Database\Factories;

use App\Enums\Sms\SmsMessageType;
use App\Enums\Sms\SmsProvider;
use App\Enums\Sms\SmsSenderNumber;
use App\Enums\Sms\SmsStatus;
use App\Enums\Sms\SmsType;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsLogFactory extends Factory
{
    protected $model = SmsLog::class;

    public function definition(): array
    {
        return [
            'message_id' => $this->faker->numberBetween(10000, 9999),
            'user_id' => User::factory(),
            'connector' => SmsProvider::random(),
            'type' => SmsType::random(),
            'status' => SmsStatus::random(),
            'message_type' => SmsMessageType::random(),
            'sender_number' => SmsSenderNumber::random(),
            'to' => '09121234567',
            'sent_at' => now(),
            'delivered_at' => null,
            'message' => $this->faker->text,
        ];
    }
}
