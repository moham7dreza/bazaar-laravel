<?php

declare(strict_types=1);

namespace App\Enums;

enum StorageDisk: string
{
    case LOCAL   = 'local';
    case PUBLIC  = 'public';
    case PRIVATE = 'private';
    case BACKUPS = 'backups';
    case MEDIA   = 'media';
}
