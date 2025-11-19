<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Classes\ContextItem;
use App\Models\User;
use App\Services\RolePermissionService;
use Illuminate\Database\Seeder;

final class PermissionSeeder extends Seeder
{
    public function __construct(
        private readonly RolePermissionService $rolePermissionService,
    ) {
    }

    public function run(): void
    {
        $this->rolePermissionService->forgetCachedPermissions();

        $this->rolePermissionService->seedPermissions();

        $this->command->info('permissions created.');

        $this->rolePermissionService->seedRoles();

        $this->command->info('roles created.');

        $this->assignRoleToAdmin();
    }

    private function assignRoleToAdmin(): void
    {
        if (app()->runningUnitTests())
        {
            return;
        }

        $this->rolePermissionService->syncAdminRolePermissions();

        $this->command->info('permissions assigned to admin role.');

        $admin = User::factory()->create([
            'name' => 'admin',
        ]);

        context()->add(ContextItem::Admin, $admin);

        $this->command->info('admin user ok.');

        $this->rolePermissionService->assignAdminRole($admin);

        $this->command->info('role and permissions assigned to admin user.');

        auth()->login($admin, remember: true);

        $this->command->info('admin user logged in.');
    }
}
