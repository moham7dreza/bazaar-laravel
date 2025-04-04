<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum SmsStatus: string
{
    use EnumDataListTrait;

    case SENT = 'sent';
}
