<?php

declare(strict_types=1);

namespace App\Console\Commands\System;

use App\Enums\UserRole;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;

use function Laravel\Prompts\info;

class SyncRoleHasPermissionsCommand extends Command implements Isolatable
{
    protected $signature = 'permission:update-acl {--sync} {--pretend}';

    public function handle(): int
    {
        $shouldSync = $this->option('sync');
        $pretend    = $this->option('pretend');

        if($pretend)
        {
            info('pretending...');
        }

        foreach (UserRole::cases() as $role)
        {
            $permissions        = $role->getPermissionNames();
            $roleModel          = $role->model();
            $currentPermissions = $roleModel->getPermissionNames()->toArray();
            $newPermissions     = array_diff($permissions, $currentPermissions);
            $removedPermissions = array_diff($currentPermissions, $permissions);

            if(blank($newPermissions) && blank($removedPermissions))
            {
                info($role->value . "'s permissions not changed");
                continue;
            }

            $changes = [
                'role'               => $role->value,
                'new permissions'    => $newPermissions,
                'remove permissions' => $removedPermissions,
            ];

            info(print_r($changes, true));

            logger('role has permission changes', $changes);

            if($pretend)
            {
                continue;
            }

            if($shouldSync)
            {
                $roleModel->syncPermissions($permissions);
            }
            elseif (filled($newPermissions))
            {
                $roleModel->givePermissionTo($newPermissions);
                info($role->value . ' has new permissions : ' . implode(', ', $newPermissions));
            }
        }

        return static::SUCCESS;
    }
}
