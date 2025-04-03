<?php

namespace App\Models\Advertise;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use CascadeSoftDeletes, HasFactory, SoftDeletes;

    protected $cascadeDeletes = ['children'];

    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }
}
