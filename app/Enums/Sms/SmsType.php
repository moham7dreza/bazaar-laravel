<?php

namespace App\Enums\Sms;

use App\Traits\EnumDataListTrait;

enum SmsType: string
{
    use EnumDataListTrait;

    case SEND = 'send';
    case RECEIVE = 'receive';
}
