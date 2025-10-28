<?php

declare(strict_types=1);

namespace App\Models;

use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class ChFavorite extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use UUID;
}
