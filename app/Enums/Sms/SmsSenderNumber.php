<?php

declare(strict_types=1);

namespace App\Enums\Sms;

use App\Enums\Concerns\EnumDataListTrait;

enum SmsSenderNumber: string
{
    use EnumDataListTrait;

    case NUMBER_1 = '10009000';
    case NUMBER_2 = '300024444';
}
