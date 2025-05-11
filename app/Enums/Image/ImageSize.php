<?php

declare(strict_types=1);

namespace App\Enums\Image;

enum ImageSize: string
{
    case SMALL  = 'small';
    case MEDIUM = 'medium';
    case LARGE  = 'large';
}
