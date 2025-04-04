<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum SmsProvider: string
{
    use EnumDataListTrait;

    case KAVENEGAR = 'kavenegar';
}
