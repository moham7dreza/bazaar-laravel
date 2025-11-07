<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Throwable;

class Impersonator
{
    /**
     * Impersonate the given user.
     *
     * @throws Throwable
     */
    public function take(Authenticatable $user): void
    {
        throw_if(
            condition: $this->impersonating(),
            exception: AuthenticationException::class,
            parameters: 'Cannot impersonate while already impersonating'
        );

        throw_if(
            condition: ! auth()->check(),
            exception: AuthenticationException::class,
            parameters: 'Cannot impersonate without a currently authenticated user'
        );

        session()->put($this->sessionName(), auth()->id());

        session()->regenerate();

        auth()->login($user);
    }

    /**
     * Stop impersonating a user and resume the original authentication state.
     *
     * @return void
     */
    public function stop(): void
    {
        if ($id = session()->pull($this->sessionName()))
        {
            auth()->loginUsingId($id);

            session()->regenerate();
        }
    }

    /**
     * Determine if the current user is impersonating another user.
     *
     * @return bool
     */
    public function impersonating(): bool
    {
        return session()->has($this->sessionName());
    }

    /**
     * Get a unique identifier for the impersonator session value.
     *
     * @return string
     */
    public function sessionName(): string
    {
        return 'impersonator_web_' . sha1(static::class);
    }
}
