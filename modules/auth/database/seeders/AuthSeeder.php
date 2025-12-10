<?php

declare(strict_types=1);

namespace Modules\Auth\Database\Seeders;

use Illuminate\Container\Attributes\Context;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\Auth\Enums\NoticeType;
use Modules\Auth\Models\Otp;

final class AuthSeeder extends Seeder
{
    public function run(
        #[Context('users')]
        Collection $users,
    ): void {
        Otp::factory(2)
            ->for($users->random()->first())
            ->sequence(
                ['type' => NoticeType::Email],
                ['type' => NoticeType::Sms],
            )->insert();

        $this->command->alert('Relations seeded');
    }
}
