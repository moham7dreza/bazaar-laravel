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
            Environment::LOCAL->value, Environment::TESTING->value => ClientDomain::Local,
            Environment::STAGING->value => BaseUrlUtility::getBaseUrlForStaging(request()->host()),
            default                     => ClientDomain::ProdIR,
        };
    }
}
