<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\EnumDataListTrait;
use Illuminate\Support\Facades\Storage;

enum Disk: string
{
    use EnumDataListTrait;

    case Local   = 'local';

    case Public  = 'public';

    case Private = 'private';

    case Backups = 'backups';

    case Media   = 'media';

    public static function setDisksAsFake(): void
    {
        self::totalCases()
            ->each(fn (self $case) => $case->fake());
    }

    public function fake(): void
    {
        Storage::fake($this);
    }
}
