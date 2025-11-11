<?php

declare(strict_types=1);

namespace App\Enums;

enum StorageDisk: string
{
    case Local   = 'local';
    case Public  = 'public';
    case Private = 'private';
    case Backups = 'backups';
    case Media   = 'media';
}
