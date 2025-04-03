<?php

namespace App\Traits;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasParent
{
    use CascadeSoftDeletes;
    use SoftDeletes;

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
