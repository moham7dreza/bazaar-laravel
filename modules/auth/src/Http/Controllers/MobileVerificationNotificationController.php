<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class MobileVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedMobile())
        {
            return redirect()->intended();
        }

        $request->user()->sendMobileVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
