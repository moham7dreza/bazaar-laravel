<?php

declare(strict_types=1);

namespace Modules\Auth\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\NoticeType;
use Modules\Auth\Models\Otp;

final class AuthSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(5)->create();

        Otp::factory(2)
            ->for($users->random()->first())
            ->sequence(
                ['type' => NoticeType::EMAIL],
                ['type' => NoticeType::SMS],
            )->create();

        $this->command->alert('Relations seeded');
    }
}
