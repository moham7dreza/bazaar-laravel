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
        Schema::table('users', function (Blueprint $table): void {
            $table->string('mobile')->nullable()->unique();
            $table->dateTime('mobile_verified_at')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->string('avatar_url')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'mobile',
                'mobile_verified_at',
                'city_id',
                'is_active',
                'avatar_url',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
