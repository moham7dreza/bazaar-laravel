<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum QueueEnum: string
{
    use EnumDataListTrait;

    case HIGH = 'high';
    case MONGO_LOG = 'mongo-log';
}
