<?php

namespace App\Enums\Sms;

use App\Traits\EnumDataListTrait;

enum SmsProvider: string
{
    use EnumDataListTrait;

    case KAVENEGAR = 'kavenegar';
    case DEBUG = 'debug';
}
