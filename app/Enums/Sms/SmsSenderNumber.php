<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsSenderNumber: string
{
    use EnumDataListTrait;

    case Number1 = '10009000';

    case Number2 = '300024444';
}
