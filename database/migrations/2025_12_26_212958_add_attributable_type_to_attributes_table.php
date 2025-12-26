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
        Schema::table('attributes', function (Blueprint $table): void {
            // Rename 'attributable' to 'attributable_type' to match Laravel's standard
            $table->renameColumn('attributable', 'attributable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table): void {
            // Rename back to 'attributable'
            $table->renameColumn('attributable_type', 'attributable');
        });
    }
};
