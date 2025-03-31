<?php

namespace App\Models\Monitor;

use MongoDB\Laravel\Eloquent\Model;

class DevLog extends Model
{
    protected $collection = 'dev_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
