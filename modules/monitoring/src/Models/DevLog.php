<?php

declare(strict_types=1);

namespace Modules\Monitoring\Models;

use MongoDB\Laravel\Eloquent\Model;

final class DevLog extends Model
{
    protected $table = 'dev_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
