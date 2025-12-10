<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Classes\ContextItem;
use App\Console\Commands\System\SyncRoleHasPermissionsCommand;
use App\Models\User;
use App\Services\RolePermissionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

final class PermissionSeeder extends Seeder
{
    public function __construct(
        private readonly RolePermissionService $rolePermissionService,
    ) {
    }

    public function run(): void
    {
        $this->command->info('[ + ] Step 1 permission cache reset.');

        $this->rolePermissionService->forgetCachedPermissions();

        $this->command->info('[ + ] Step 2 permissions seeding.');

        $this->rolePermissionService->seedPermissions();

        $this->command->info('[ + ] Step 3 roles seeding.');

        $this->rolePermissionService->seedRoles();

        $this->command->info('[ + ] Step 4 admin preparing.');

        $this->assignRoleToAdmin();

        $this->command->info('[ + ] Step 5 roles and permissions syncing.');

        Artisan::call(SyncRoleHasPermissionsCommand::class, [
            '--sync'    => true,
            '--pretend' => false,
        ]);

        $this->command->info('[ + ] Step 6 finish seeder.');
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
