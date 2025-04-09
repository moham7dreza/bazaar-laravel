<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->nullable()->after('email')->unique();
            $table->dateTime('mobile_verified_at')->nullable()->after('email');
            $table->foreignId('city_id')->after('email')->nullable()->constrained('cities');
            $table->tinyInteger('is_active')->default(0)->after('email');
            $table->tinyInteger('user_type')->default(0)->after('email');
            $table->timestamp('suspended_at')->nullable()->after('email');
            $table->timestamp('suspended_until')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
