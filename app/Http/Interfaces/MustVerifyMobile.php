<?php

namespace App\Http\Interfaces;

interface MustVerifyMobile
{
    public function hasVerifiedMobile();

    /**
     * Mark the given user's mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified();

    /**
     * Send the mobile verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification();

    /**
     * Get the mobile address that should be used for verification.
     *
     * @return string
     */
    public function getMobileForVerification();
}
