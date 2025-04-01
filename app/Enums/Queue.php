<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum Queue: string
{
    use EnumDataListTrait;

    case DEFAULT = 'default';
    case HIGH = 'high';
    case LOW = 'low';
    case MONGO_LOG = 'mongo-log';
}
