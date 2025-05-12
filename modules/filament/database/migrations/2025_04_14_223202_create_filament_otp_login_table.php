<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        $table_name = config('filament-otp-login.table_name');

        Schema::create($table_name, function (Blueprint $table): void {
            $table->id();
            $table->string('code');
            $table->string('email');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }
};
