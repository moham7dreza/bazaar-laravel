<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Payment\Enums\PaymentStatus;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('payments', callback: static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('advertisement_id')
                ->constrained('advertisements')
                ->nullable()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('amount');
            $table->text('description')
                ->nullable();
            $table->tinyInteger('status')
                ->unsigned()
                ->default(PaymentStatus::Pending->value);
            $table->text('authority')
                ->comment('return code from gateway')
                ->nullable();
            $table->text('ref_id')
                ->nullable();
            $table->text('card_pan')
                ->nullable();
            $table->text('trace_no')
                ->nullable();
            $table->text('gateway_response')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
