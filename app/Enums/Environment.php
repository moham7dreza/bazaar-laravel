<?php

declare(strict_types=1);

namespace App\Enums;

enum Environment: string
{
    case Production = 'production';
    case Staging    = 'staging';
    case Testing    = 'testing';
    case Local      = 'local';

    public function is(): bool|string
    {
        return app()->environment($this->value);
    }
}
