<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;

enum Queue: string
{
    use EnumDataListTrait;

    case Default   = 'default';

    case High      = 'high';

    case Low       = 'low';

    case Backup    = 'backup';

    case Mail      = 'mail';

    case MongoLog  = 'mongo-log';
}
