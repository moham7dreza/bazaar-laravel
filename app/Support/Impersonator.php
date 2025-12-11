<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\ExceptionCode;
use App\Exceptions\BusinessAuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;

class Impersonator
{
    /**
     * Impersonate the given user.
     *
     * @throws BusinessAuthenticationException
     */
    public function take(Authenticatable $user): void
    {
        if ($this->impersonating())
        {
            throw new BusinessAuthenticationException(
                exceptionCode: ExceptionCode::OperationNotAllowed,
                message: 'Cannot impersonate while already impersonating',
                context: [
                    'current_impersonator_id' => session()->get($this->sessionName()),
                    'target_user_id'          => $user->getAuthIdentifier(),
                ]
            );
        }

        throw_unless(auth()->check(), BusinessAuthenticationException::class, exceptionCode: ExceptionCode::Unauthenticated, message: 'Cannot impersonate without a currently authenticated user');

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
