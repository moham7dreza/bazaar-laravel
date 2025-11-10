<?php

declare(strict_types=1);

namespace App\Services\Contexts;

use App\Classes\ContextItem;
use Illuminate\Support\Str;

/**
 * add persistent metadata throughout request lifecycle.
 */
final class RequestContext
{
    public function __construct()
    {
        context()->add(ContextItem::RequestId, Str::uuid()->toString());
    }

    public function addBasicContexts(): void
    {
        context()->add(ContextItem::Path, request()->path());
        context()->add(ContextItem::Host, request()->host());
        context()->add(ContextItem::Ip, request()->ip());
        context()->add(ContextItem::Url, request()->url());
        context()->add(ContextItem::Hostname, gethostname());
        context()->add(ContextItem::Method, request()->method());
        context()->add(ContextItem::Referer, request()->header('referer'));
        //        context()->addHidden(ContextItem::Session, request()?->session()?->getId());
    }

    public function addUserContext(): void
    {
        if ( ! $user = auth()->user())
        {
            return;
        }

        context()->add(ContextItem::UserId, $user->id);
        context()->add(ContextItem::UserType, $user->user_type);
    }
}
