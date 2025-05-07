<?php

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;

enum UserPermission: string
{
    use EnumDataListTrait;

    case SEE_PANEL    = 'see_panel';
    case MANAGE_USERS = 'manage_users';
    // Advertisement
    case EDIT_AD    = 'edit_ad';
    case EDIT_ADS   = 'edit_ads';
    case CREATE_AD  = 'create_ad';
    case DESTROY_AD = 'destroy_ad';
    case PUBLISH_AD = 'publish_ad';

    public function isAdminLevel(): bool
    {
        $permissions = [
            self::SEE_PANEL,
            self::MANAGE_USERS,
        ];

        return in_array($this, $permissions, true);
    }

    public static function ads(): array
    {
        return [
            self::EDIT_AD,
            self::EDIT_ADS,
            self::CREATE_AD,
            self::DESTROY_AD,
            self::PUBLISH_AD,
        ];
    }
}
