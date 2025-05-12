<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('filament_exceptions_table', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 255);
            $table->string('code');
            $table->longText('message', 255);
            $table->string('file', 255);
            $table->integer('line');
            $table->text('trace');
            $table->string('method');
            $table->string('path', 255);
            $table->text('query');
            $table->text('body');
            $table->text('cookies');
            $table->text('headers');
            $table->string('ip');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('filament_exceptions_table');
    }
};
