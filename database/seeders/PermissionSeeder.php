<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Classes\ContextItem;
use App\Enums\UserId;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        UserPermission::totalCases()->each(static fn (UserPermission $permission) => Permission::query()->firstOrCreate(['name' => $permission]));
        $this->command->info('permissions created.');

        UserRole::totalCases()->each(static fn (UserRole $role) => Role::query()->firstOrCreate(['name' => $role]));
        $this->command->info('roles created.');

        $this->assignRoleToAdmin();
    }

    private function assignRoleToAdmin(): void
    {
        $role_super_admin = Role::query()->where('name', UserRole::ADMIN)->first();

        $role_super_admin->givePermissionTo(UserPermission::cases());
        $this->command->info('permissions assigned to admin role.');

        $super_admin =
//            User::query()->find(UserId::Admin) ??
            User::query()->admin()->first()
            ?? User::factory()->admin()->create();
        context()->add(ContextItem::Admin, $super_admin);

        $this->command->info('admin user ok.');

        auth()->loginUsingId($super_admin->id);
        $this->command->info('admin user logged in.');

        $super_admin->assignRole(UserRole::ADMIN);
        $this->command->info('role and permissions assigned to admin user.');
    }
}
