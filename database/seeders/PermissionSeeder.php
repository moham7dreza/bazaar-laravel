<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Classes\ContextItem;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        forgetCachedPermissions();

        UserPermission::totalCases()->each(static fn (UserPermission $permission) => Permission::query()->firstOrCreate(['name' => $permission]));

        $this->command->info('permissions created.');

        UserRole::totalCases()->each(static fn (UserRole $role) => Role::query()->firstOrCreate(['name' => $role]));

        $this->command->info('roles created.');

        $this->assignRoleToAdmin();
    }

    private function assignRoleToAdmin(): void
    {
        if (app()->runningUnitTests())
        {
            return;
        }

        UserRole::Admin->model()->givePermissionTo(UserPermission::cases());

        $this->command->info('permissions assigned to admin role.');

        $admin = User::factory()->admin()->create();

        context()->add(ContextItem::Admin, $admin);

        $this->command->info('admin user ok.');

        auth()->loginUsingId($admin->id);

        $this->command->info('admin user logged in.');

        $admin->assignRole(UserRole::Admin);

        $this->command->info('role and permissions assigned to admin user.');
    }
}
