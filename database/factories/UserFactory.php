<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\StorageDisk;
use App\Enums\Theme;
use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Override;
use Random\RandomException;

class UserFactory extends Factory
{
    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => Date::now(),
            'password'          => 'password',
            'remember_token'    => Str::random(10),
            'theme'             => Theme::Dracula->value,
            'suspended_at'      => fake()->optional(0.1)->dateTimeBetween('-30 days'),
            'suspended_until'   => fn (array $attributes) => Arr::get($attributes, 'suspended_at')
                ? Date::parse(Arr::get($attributes, 'suspended_at'))->addWeek()
                : null,
            'is_active'          => true,
            'user_type'          => User::TypeUser,
            'mobile'             => '0912' . random_int(1000000, 9999999),
            'mobile_verified_at' => Date::now(),
            'city_id'            => City::factory(),
            'avatar_url'         => '/images/admin.jpg',
            'secrets'            => [
                'stripe'  => Str::random(32),
                'open_ai' => Str::random(32),
            ],
            'last_login_at' => fake()->optional(0.8)->dateTimeBetween('-30 days'),
            'last_login_ip' => fn (array $attributes) => Arr::get($attributes, 'last_login_at') ? fake()->localIpv4() : null,
        ];
    }

    #[Override]
    public function configure(): static
    {
        return $this->afterMaking(function (User $user): void {
            // ...
        })->afterCreating(function (User $user): void {
            if ( ! isEnvTesting())
            {
                // $this->getRealProfilePhotoFor($user);
                Storage::disk(StorageDisk::Public->value)
                    ->put(
                        $user->avatar_url,
                        file_get_contents(public_path($user->avatar_url))
                    );
            }
        });
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at'  => null,
            'mobile_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            $name = Arr::get($attributes, 'name');

            return [
                'email'     => "admin-{$name}@admin.com",
                'user_type' => User::TypeAdmin,
            ];
        });
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes): array => [
            'suspended_at'    => Date::now(),
            'suspended_until' => Date::now()->addWeek(),
        ]);
    }

    /**
     * TODO: fix method.
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    private function getRealProfilePhotoFor(User $user): void
    {
        $response = Http::retry(3, 100, fn ($e, $attempts): bool => $e instanceof ConnectionException)
            ->timeout(5)
            ->get('https://thispersondoesnotexist.com/');
        $response->throw();

        $imageName = 'profile-pic.jpg';
        Storage::disk(StorageDisk::Public->value)
            ->put(
                "images/{$imageName}",
                $response->body()
            );
        $user->update(['avatar_url' => "images/{$imageName}"]);
    }
}
