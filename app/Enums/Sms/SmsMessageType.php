<?php

namespace App\Enums\Sms;

use App\Traits\EnumDataListTrait;

enum SmsMessageType: string
{
    use EnumDataListTrait;

    case DEFAULT = 'default';
    case LOGIN_OTP = 'login-otp';
}
