<?php

namespace App\Http\Contexts;

use Illuminate\Support\Str;

/**
 * add persistent metadata throughout request lifecycle.
 */
class RequestContext
{
    public function __construct()
    {
        context()->add('request_id', Str::uuid()->toString());
    }

    public function addBasicContexts(): void
    {
        context()->add('path', request()->path());
        context()->add('host', request()->host());
        context()->add('ip', request()->ip());
        context()->add('url', request()->url());
        context()->add('hostname', gethostname());
        context()->add('method', request()->method());
    }

    public function addUserContext(): void
    {
        if (! $user = getUser()) {
            return;
        }

        context()->add('user_id', $user->id);
        context()->add('user_type', $user->user_type);
    }
}
