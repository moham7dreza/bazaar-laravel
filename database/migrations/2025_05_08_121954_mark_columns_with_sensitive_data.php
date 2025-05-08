<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table): void {
            $table->string('email')->comment('sensitive_data=true')->change();
            $table->string('mobile')->comment('sensitive_data=true')->change();
            $table->string('password')->comment('sensitive_data=true')->change();
        });
    }

    public function down(): void
    {
        //
    }
};
