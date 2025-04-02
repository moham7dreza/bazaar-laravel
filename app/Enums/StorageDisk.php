<?php

namespace App\Enums;

enum StorageDisk: string
{
    case LOCAL = 'local';
    case PUBLIC = 'public';
    case PRIVATE = 'private';
}
