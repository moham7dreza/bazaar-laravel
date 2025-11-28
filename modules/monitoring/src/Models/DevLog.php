<?php

declare(strict_types=1);

namespace Modules\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

final class DevLog extends Model
{
    use HasFactory;

    protected $table = 'dev_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
