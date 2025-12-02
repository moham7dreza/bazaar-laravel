<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Concerns\EnumDataListTrait;

enum SmsMessageType: string
{
    use EnumDataListTrait;

    case Default   = 'default';

    case LoginOtp  = 'login-otp';
}
