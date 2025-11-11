<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\EnumDataListTrait;
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
}
