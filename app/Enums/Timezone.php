<?php

declare(strict_types=1);

namespace App\Enums;

enum Timezone: string
{
    case UTC    = 'UTC';
    case Tehran = 'Asia/Tehran';
}
