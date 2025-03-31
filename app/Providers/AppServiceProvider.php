<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Auth::loginUsingId(11);
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        $this->setupGates();
    }

    private function setupGates(): void
    {
        Gate::before(static function (?User $user, string $ability) {
            return $user && $user->isAdmin() ? true : null;
        });

        Gate::define('viewPulse', static function (?User $user) {
            if (app()->environment('local', 'testing')) {
                return true;
            }
            return $user?->isAdmin();
        });
    }
}
