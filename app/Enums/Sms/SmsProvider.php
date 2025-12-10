<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Concerns\EnumDataListTrait;

enum SmsProvider: string
{
    use EnumDataListTrait;

    case Kavenegar = 'kavenegar';

    case Debug     = 'debug';
}
