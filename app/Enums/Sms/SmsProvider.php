<?php

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsProvider: string
{
    use EnumDataListTrait;

    case KAVENEGAR = 'kavenegar';
    case DEBUG = 'debug';
}
