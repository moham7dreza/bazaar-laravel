<?php

namespace Database\Seeders;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // all system permissions
        foreach (UserPermission::cases() as $permission) {
            Permission::query()->updateOrCreate(['name' => $permission]);
        }
        $this->command->info('permissions created.');

        // all system roles
        foreach (UserRole::cases() as $role) {
            Role::query()->updateOrCreate(['name' => $role]);
        }
        $this->command->info('roles created.');

        $this->assignRoleToAdmin();
    }

    private function assignRoleToAdmin(): void
    {
        $role_super_admin = Role::query()->where('name', UserRole::ADMIN->value)->first();

        $role_super_admin->givePermissionTo(UserPermission::SEE_PANEL->value);
        $this->command->info('permissions assigned to admin role.');

        $super_admin = User::query()->admin()->first() ?? User::factory()->admin()->create();
        $this->command->info('admin user ok.');

//        $super_admin->update(['email_verified_at' => now()]);

        auth()->loginUsingId($super_admin->id);
        $this->command->info('admin user logged in.');

        $super_admin->assignRole(UserRole::ADMIN->value);
        $this->command->info('role and permissions assigned to admin user.');
    }
}
