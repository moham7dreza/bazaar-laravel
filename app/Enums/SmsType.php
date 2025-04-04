<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum SmsType: string
{
    use EnumDataListTrait;

    case SEND = 'send';
    case RECEIVE = 'receive';
}
