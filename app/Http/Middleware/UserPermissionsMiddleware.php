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

        $mappedPermissions = collect(
            $user->getPermissionNames()
        )->mapInto(UserPermission::class);

        $permissions = cache()->remember(
            'user:permissions:' . $user->id,
            Date::now()->plus(hours: 1),
            fn () => $mappedPermissions,
        );

        // context()->remember('user-permissions', fn () => $mappedPermissions);

        $request->merge(['cached_permissions' => $permissions]);

        return $next($request);
    }
}
