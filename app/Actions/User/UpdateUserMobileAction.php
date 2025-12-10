<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Abstracts\Action;
use App\Models\User;
use InvalidArgumentException;
use Override;

class UpdateUserMobileAction extends Action
{
    public function __construct(
        public User $user,
        public readonly string $mobile,
    ) {
    }

    public function handle(): User
    {
        $this->validateMobile();

        $this->user->update([
            'mobile' => $this->mobile,
        ]);

        return $this->user->fresh();
    }

    #[Override]
    public function authorize(): bool
    {
        return true;
    }

    private function validateMobile(): void
    {
        throw_unless(preg_match('/^\+?\d{10,15}$/', $this->mobile), InvalidArgumentException::class, 'Invalid mobile number format');
    }
}
