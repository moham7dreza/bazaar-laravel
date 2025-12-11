<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('advertisement_prices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('advertisement_id');
            $table->unsignedBigInteger('price');
            $table->string('currency', 3)->default(config()->string('app.currency'));
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_prices');
    }
};
