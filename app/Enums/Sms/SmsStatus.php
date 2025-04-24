<?php

namespace App\Enums\Sms;

use App\Traits\EnumDataListTrait;

enum SmsStatus: string
{
    use EnumDataListTrait;

    case SENT = 'sent';
    case QUEUED = 'queued';
}
