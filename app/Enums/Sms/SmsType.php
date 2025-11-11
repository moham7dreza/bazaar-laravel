<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsType: string
{
    use EnumDataListTrait;

    case Send    = 'send';
    case Receive = 'receive';
}
