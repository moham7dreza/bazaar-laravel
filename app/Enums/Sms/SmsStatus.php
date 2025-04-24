<?php

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsStatus: string
{
    use EnumDataListTrait;

    case SENT = 'sent';
    case QUEUED = 'queued';
}
