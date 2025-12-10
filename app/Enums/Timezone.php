<?php

declare(strict_types=1);

namespace App\Enums;

enum Timezone: string
{
    case Utc    = 'UTC';
    case Tehran = 'Asia/Tehran';
}
