<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('user_action_tags', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('action_tag');
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_action_tags');
    }
};
