<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Abstracts\Action;
use App\Models\User;
use InvalidArgumentException;

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

    public function authorize(): bool
    {
        return true;
        //        return auth()->user()->isAdmin();
    }

    private function validateMobile(): void
    {
        if ( ! preg_match('/^\+?\d{10,15}$/', $this->mobile))
        {
            throw new InvalidArgumentException('Invalid mobile number format');
        }
    }
}
