<?php

namespace Database\Factories;

use App\Enums\SmsMessageType;
use App\Enums\SmsProvider;
use App\Enums\SmsSenderNumber;
use App\Enums\SmsStatus;
use App\Enums\SmsType;
use App\Models\Monitor\SmsLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsLogFactory extends Factory
{
    protected $model = SmsLog::class;

    public function definition(): array
    {
        return [
            'message_id' => $this->faker->uuid,
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
