<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Disk;
use App\Enums\Theme;
use App\Models\Geo\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'name'              => persian_faker()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => Date::now(),
            'password'          => 'password',
            'remember_token'    => Str::random(10),
            'theme'             => Theme::Dracula->value,
            // TODO remove
            'suspended_at'    => fake()->optional(0.1)->dateTimeBetween('-30 days'),
            'suspended_until' => fn (array $attributes) => Arr::get($attributes, 'suspended_at')
                ? Date::parse(Arr::get($attributes, 'suspended_at'))->addWeek()
                : null,
            'is_active'          => true,
            'mobile'             => persian_faker()->cellPhone(),
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
            if (app()->runningUnitTests())
            {
                return;
            }

            // $this->getRealProfilePhotoFor($user);
            Storage::disk(Disk::Public)
                ->put(
                    $user->avatar_url,
                    file_get_contents(public_path($user->avatar_url))
                );
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
        return $this->afterCreating(function (User $user): void {
            $user->makeAdmin();
        });
    }

    // TODO remove
    public function suspended(): static
    {
        return $this->state(fn (array $attributes): array => [
            'suspended_at'    => Date::now(),
            'suspended_until' => Date::now()->addWeek(),
        ]);
    }

    /**
     * TODO: fix method.
     */
    private function getRealProfilePhotoFor(User $user): void
    {
        Storage::disk(Disk::Public)
            ->put(
                $url = 'images/profile-pic.jpg',
                Http::profile()->body()
            );

        $user->update([
            'avatar_url' => $url,
        ]);
    }
}
