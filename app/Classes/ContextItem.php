<?php

declare(strict_types=1);

namespace App\Classes;

final readonly class ContextItem
{
    const string PerPage = 'per_page';

    const string ResponseTime = 'response_time';

    const string StatusCode = 'status_code';

    const string RequestId = 'request_id';

    const string Path = 'path';

    const string Host = 'host';

    const string Ip = 'ip';

    const string Url = 'url';

    const string Hostname = 'hostname';

    const string Method = 'method';

    const string Referer = 'referer';

    const string UserId = 'user_id';

    const string UserType = 'user_type';

    const string Session = 'session';

    const string Admin = 'admin';

    const string Users = 'users';
}
