<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Abstracts\Action;
use App\Models\User;

class UpdateUserSecretAction extends Action
{
    public function __construct(
        public User $user,
        public readonly string $key,
        public readonly string $value,
    ) {
    }

    public function handle(): User
    {
        $this->user->secrets = array_merge(
            (array) $this->user->secrets,
            [$this->key => $this->value],
        );
        $this->user->save();

        return $this->user;
    }

    public function authorize(): bool
    {
        return true;
    }
}
