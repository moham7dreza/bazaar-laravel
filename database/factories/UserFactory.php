<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\StorageDisk;
use App\Enums\Theme;
use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Random\RandomException;

class UserFactory extends Factory
{
    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'name'               => fake()->name(),
            'email'              => fake()->unique()->safeEmail(),
            'email_verified_at'  => now(),
            'password'           => 'password',
            'remember_token'     => Str::random(10),
            'theme'              => Theme::DRACULA->value,
            'suspended_at'       => null,
            'suspended_until'    => null,
            'is_active'          => true,
            'user_type'          => User::TYPE_USER,
            'mobile'             => '0912' . random_int(1000000, 9999999),
            'mobile_verified_at' => now(),
            'city_id'            => City::factory(),
            'avatar_url'         => '/images/admin.jpg',
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (User $user): void {
            // ...
        })->afterCreating(function (User $user): void {
            if ( ! isEnvTesting())
            {
                //                $response = Http::get('https://thispersondoesnotexist.com/');
                //
                //                $imageName = 'profile-pic.jpg';
                Storage::disk(StorageDisk::PUBLIC->value)->put($user->avatar_url, file_get_contents(public_path($user->avatar_url)));
                //                Storage::disk(StorageDisk::PUBLIC->value)->put("images/{$imageName}", $response->body());
                //
                //                $user->update(['avatar_url' => "images/{$imageName}"]);
            }
        });
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at'  => null,
            'mobile_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name'       => 'admin',
            'email'      => 'admin@admin.com',
            'user_type'  => User::TYPE_ADMIN,
            'mobile'     => fake()->randomElement(config('developer.backends')),
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'suspended_at'    => now(),
            'suspended_until' => now()->addWeek(),
        ]);
    }
}
