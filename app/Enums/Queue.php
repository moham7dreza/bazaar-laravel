<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum Queue: string
{
    use EnumDataListTrait;

    case DEFAULT   = 'default';
    case HIGH      = 'high';
    case LOW       = 'low';
    case BACKUP    = 'backup';
    case MAIL      = 'mail';
    case MONGO_LOG = 'mongo-log';
    case SEARCH    = 'search';
}
