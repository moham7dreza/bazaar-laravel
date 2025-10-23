<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Notifications\VerifyMobileNotification;

trait MustVerifyMobile
{
    public function hasVerifiedMobile(): bool
    {
        return null !== $this->mobile_verified_at;
    }

    /**
     * Mark the given user's mobile as verified.
     */
    public function markMobileAsVerified(): bool
    {
        return $this->forceFill([
            'mobile_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the mobile verification notification.
     */
    public function sendMobileVerificationNotification(): void
    {
        $this->notify(new VerifyMobileNotification());
    }

    /**
     * Get the mobile number that should be used for verification.
     */
    public function getMobileForVerification(): string
    {
        return $this->mobile;
    }
}
