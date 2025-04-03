<?php

namespace App\Models\Monitor;

use MongoDB\Laravel\Eloquent\Model;

class SmsLog extends Model
{
    protected $collection = 'sms_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            //            'connector' => SmsProviderEnum::class,
            //            'status' => SmsStatusEnum::class,
            //            'type' => SmsTypeEnum::class,
            //            'message_type' => SmsMessageTypeEnum::class,
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }
}
