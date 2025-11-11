<?php

declare(strict_types=1);

namespace App\Enums;

enum Theme: string
{
    case Default = 'default';
    case Dracula = 'dracula';
    case Nord    = 'nord';
    case Sunset  = 'sunset';
}
