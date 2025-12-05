<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WooServ\LaravelObjectId\Concerns\HasObjectIds;

#[ScopedBy([LatestScope::class])]
class Item extends Model
{
    use HasFactory;

    use HasObjectIds;

    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [

        ];
    }
}
