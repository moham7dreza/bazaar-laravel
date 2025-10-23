<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsStatus: string
{
    use EnumDataListTrait;

    case SENT   = 'sent';
    case QUEUED = 'queued';
}
