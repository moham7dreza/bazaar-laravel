<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\ClientDomain;
use App\Enums\Environment;
use App\Models\User;

class ClientDomainService
{
    public static function getUserDomainWithFallback(User $user): ClientDomain
    {
        return $user->getDomain() ?? self::getFallbackDomain();
    }

    public static function getFallbackDomain(): ClientDomain
    {
        return match (app()->environment())
        {
            Environment::Local->value, Environment::Testing->value => ClientDomain::Local,
            Environment::Staging->value => BaseUrlUtility::getBaseUrlForStaging(request()->host()),
            default                     => ClientDomain::ProdIR,
        };
    }

    public static function getDomainWithFallBack(): ClientDomain
    {
        return auth()->check() ?
            self::getUserDomainWithFallback(auth()->user()) :
            self::getFallbackDomain();
    }
}
