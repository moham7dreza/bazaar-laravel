<?php

namespace Modules\Monitoring\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum CommandLoggingStatus: string
{
    use EnumDataListTrait;

    case Started = 'started';
    case Completed = 'completed';
}
