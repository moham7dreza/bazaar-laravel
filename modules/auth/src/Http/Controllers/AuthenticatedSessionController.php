<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Http\Requests\LoginRequest;

final class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
