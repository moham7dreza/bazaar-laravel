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
        Schema::create('sms_logs', function (Blueprint $table): void {
            $table->id();
            $table->string('message_id', 30)->nullable();
            $table->string('connector', 30); // SmsProvider enum
            $table->string('type', 30); // SmsType enum
            $table->string('status')->nullable(); // SmsStatus enum
            $table->string('message_type')->default(App\Enums\Sms\SmsMessageType::DEFAULT->value); // SmsMessageType enum
            $table->string('sender_number', 25)->index(); // SmsSenderNumber enum
            $table->string('to', 25)->index();
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamp('delivered_at')->nullable();
            $table->text('message');
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['message_id', 'connector']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
