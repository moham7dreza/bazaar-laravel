<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use Spatie\Permission\Models\Permission;

enum UserPermission: string
{
    use EnumDataListTrait;

    case SeePanel    = 'see_panel';
    case ManageUsers = 'manage_users';
    // Advertisement
    case EditAd    = 'edit_ad';
    case EditAds   = 'edit_ads';
    case CreateAd  = 'create_ad';
    case DestroyAd = 'destroy_ad';
    case PublishAd = 'publish_ad';

    // TODO should be removed after seeder fix
    public static function ads(): array
    {
        return [
            self::EditAd,
            self::EditAds,
            self::CreateAd,
            self::DestroyAd,
            self::PublishAd,
        ];
    }

    public function isAdminLevel(): bool
    {
        $permissions = [
            self::SeePanel,
            self::ManageUsers,
        ];

        return in_array($this, $permissions, true);
    }

    public function model(): Permission
    {
        return Permission::findByName($this->value);
    }
}
