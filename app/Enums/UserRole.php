<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
use App\Enums\UserPermission as P;
use Spatie\Permission\Models\Role;

enum UserRole: string
{
    use EnumDataListTrait;

    case Admin  = 'admin';

    case Writer = 'writer';

    case Editor = 'editor';

    public function model(): Role
    {
        return Role::findByName($this->value);
    }

    public function permissions(): array
    {
        return match ($this)
        {
            self::Admin  => P::cases(),
            self::Writer => [
                P::EditAd,
                P::CreateAd,
            ],
            self::Editor => [
                P::EditAd,
                P::EditAds,
                P::CreateAd,
                P::DestroyAd,
                P::PublishAd,
            ],
        };
    }

    public function getPermissionNames(): array
    {
        return collect($this->permissions())->map->value->toArray();
    }

    public function rateLimit(): int
    {
        return match ($this)
        {
            self::Admin  => 100,
            self::Writer => 50,
            self::Editor => 50,
        };
    }
}
