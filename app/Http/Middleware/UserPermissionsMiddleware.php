<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

final class UserPermissionsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (blank($user))
        {
            return $next($request);
        }

        $permissions = cache()->remember(
            "user:permissions:{$user->id}",
            Date::now()->addHour(),
            fn () => collect(
                $user->getPermissionNames()
            )->mapInto(UserPermission::class),
        );

        $request->merge(['permissions' => $permissions]);

        return $next($request);
    }
}
