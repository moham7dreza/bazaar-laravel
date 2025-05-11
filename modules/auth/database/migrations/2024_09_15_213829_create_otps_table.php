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
        Schema::create('otps', function (Blueprint $table): void {
            $table->id();
            $table->string('token');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('otp_code');
            $table->string('login_id');
            $table->tinyInteger('type')->default(0)->comment('0 => sms, 1 => email'); // NoticeType enum
            $table->tinyInteger('used')->default(0)->comment('0 => not used, 1 => used');
            $table->tinyInteger('attempts')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
