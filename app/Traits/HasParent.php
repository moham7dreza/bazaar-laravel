<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

trait HasParent
{
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $cascadeDeletes = ['children'];

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne($this, 'parent_id');
    }
}
