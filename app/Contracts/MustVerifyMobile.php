<?php

declare(strict_types=1);

namespace App\Contracts;

interface MustVerifyMobile
{
    public function hasVerifiedMobile(): bool;

    /**
     * Mark the given user's mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified(): bool;

    /**
     * Send the mobile verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification(): void;

    /**
     * Get the mobile address that should be used for verification.
     *
     * @return string
     */
    public function getMobileForVerification(): string;
}
