<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    public function shouldRun(): bool
    {
        return (bool) DB::connection('mongodb')->getPdo();
    }

    public function up(): void
    {
        DB::connection('mongodb')->getCollection('user_action_tags')
            ->createIndex(['user_id' => 1]); // 1 for ascending order
    }

    public function down(): void
    {
        DB::connection('mongodb')->dropCollection('user_action_tags');
    }
};
