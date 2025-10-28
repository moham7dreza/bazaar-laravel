<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams           = config('permission.teams');
        $tableNames      = config('permission.table_names');
        $columnNames     = config('permission.column_names');
        $pivotRole       = Illuminate\Support\Arr::get($columnNames, 'role_pivot_key', 'role_id');
        $pivotPermission = Illuminate\Support\Arr::get($columnNames, 'permission_pivot_key', 'permission_id');

        throw_if(empty($tableNames), Exception::class, 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        throw_if($teams && empty(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key', null)), Exception::class, 'Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');

        Schema::create(Illuminate\Support\Arr::get($tableNames, 'permissions'), static function (Blueprint $table): void {
            // $table->engine('InnoDB');
            $table->bigIncrements('id'); // permission id
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create(Illuminate\Support\Arr::get($tableNames, 'roles'), static function (Blueprint $table) use ($teams, $columnNames): void {
            // $table->engine('InnoDB');
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) // permission.testing is a fix for sqlite testing
            {$table->unsignedBigInteger(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'))->nullable();
                $table->index(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'), 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();
            if ($teams || config('permission.testing'))
            {
                $table->unique([Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'), 'name', 'guard_name']);
            } else
            {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create(Illuminate\Support\Arr::get($tableNames, 'model_has_permissions'), static function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams): void {
            $table->unsignedBigInteger($pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger(Illuminate\Support\Arr::get($columnNames, 'model_morph_key'));
            $table->index([Illuminate\Support\Arr::get($columnNames, 'model_morph_key'), 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on(Illuminate\Support\Arr::get($tableNames, 'permissions'))
                ->onDelete('cascade');
            if ($teams)
            {
                $table->unsignedBigInteger(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'));
                $table->index(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'), 'model_has_permissions_team_foreign_key_index');

                $table->primary(
                    [Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'), $pivotPermission, Illuminate\Support\Arr::get($columnNames, 'model_morph_key'), 'model_type'],
                    'model_has_permissions_permission_model_type_primary'
                );
            } else
            {
                $table->primary(
                    [$pivotPermission, Illuminate\Support\Arr::get($columnNames, 'model_morph_key'), 'model_type'],
                    'model_has_permissions_permission_model_type_primary'
                );
            }

        });

        Schema::create(Illuminate\Support\Arr::get($tableNames, 'model_has_roles'), static function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams): void {
            $table->unsignedBigInteger($pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger(Illuminate\Support\Arr::get($columnNames, 'model_morph_key'));
            $table->index([Illuminate\Support\Arr::get($columnNames, 'model_morph_key'), 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on(Illuminate\Support\Arr::get($tableNames, 'roles'))
                ->onDelete('cascade');
            if ($teams)
            {
                $table->unsignedBigInteger(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'));
                $table->index(Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'), 'model_has_roles_team_foreign_key_index');

                $table->primary(
                    [Illuminate\Support\Arr::get($columnNames, 'team_foreign_key'), $pivotRole, Illuminate\Support\Arr::get($columnNames, 'model_morph_key'), 'model_type'],
                    'model_has_roles_role_model_type_primary'
                );
            } else
            {
                $table->primary(
                    [$pivotRole, Illuminate\Support\Arr::get($columnNames, 'model_morph_key'), 'model_type'],
                    'model_has_roles_role_model_type_primary'
                );
            }
        });

        Schema::create(Illuminate\Support\Arr::get($tableNames, 'role_has_permissions'), static function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission): void {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on(Illuminate\Support\Arr::get($tableNames, 'permissions'))
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on(Illuminate\Support\Arr::get($tableNames, 'roles'))
                ->onDelete('cascade');

            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app(Illuminate\Contracts\Cache\Factory::class)
            ->store('default' !== config('permission.cache.store') ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        throw_if(empty($tableNames), Exception::class, 'Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');

        Schema::drop(Illuminate\Support\Arr::get($tableNames, 'role_has_permissions'));
        Schema::drop(Illuminate\Support\Arr::get($tableNames, 'model_has_roles'));
        Schema::drop(Illuminate\Support\Arr::get($tableNames, 'model_has_permissions'));
        Schema::drop(Illuminate\Support\Arr::get($tableNames, 'roles'));
        Schema::drop(Illuminate\Support\Arr::get($tableNames, 'permissions'));
    }
};
