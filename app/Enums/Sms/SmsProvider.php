<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsProvider: string
{
    use EnumDataListTrait;

    case KAVENEGAR = 'kavenegar';
    case DEBUG     = 'debug';
}
