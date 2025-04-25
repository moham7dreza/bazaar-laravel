<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum UserPermission: string
{
    use EnumDataListTrait;

    case SEE_PANEL = 'see_panel';
    case MANAGE_USERS = 'manage_users';

    public function isAdminLevel(): bool
    {
        $permissions = [
            self::SEE_PANEL,
            self::MANAGE_USERS,
        ];

        return in_array($this, $permissions, true);
    }
}
