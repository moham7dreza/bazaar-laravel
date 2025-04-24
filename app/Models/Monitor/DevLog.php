<?php

namespace App\Models\Monitor;

use MongoDB\Laravel\Eloquent\Model;

class DevLog extends Model
{
    protected $table = 'dev_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
