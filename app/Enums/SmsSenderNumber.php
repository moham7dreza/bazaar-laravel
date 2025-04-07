<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum SmsSenderNumber: string
{
    use EnumDataListTrait;

    case NUMBER_1 = '10009000';
    case NUMBER_2 = '300024444';
}
