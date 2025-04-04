<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum SmsMessageType: string
{
    use EnumDataListTrait;

    case LOGIN_OTP = 'login-otp';
}
