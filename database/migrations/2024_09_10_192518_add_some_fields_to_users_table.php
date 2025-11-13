<?php

declare(strict_types=1);

use App\Models\User;
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
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('user_type')->default(User::TypeUser);
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('suspended_until')->nullable();
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
                'user_type',
                'suspended_at',
                'suspended_until',
                'avatar_url',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
