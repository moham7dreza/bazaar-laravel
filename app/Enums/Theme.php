<?php

declare(strict_types=1);

namespace App\Enums;

enum Theme: string
{
    case DEFAULT = 'default';
    case DRACULA = 'dracula';
    case NORD    = 'nord';
    case SUNSET  = 'sunset';
}
