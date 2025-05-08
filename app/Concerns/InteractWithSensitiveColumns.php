<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @mixin Model
 */
trait InteractWithSensitiveColumns
{
    /**
     * @return Collection<string>
     */
    public function getSensitiveColumns(): Collection
    {
        return $this->getConnection()
            ->table('INFORMATION_SCHEMA.COLUMNS')
            ->where('TABLE_NAME', $this->getTable())
            ->where('COLUMN_COMMENT', 'like', '%sensitive_data=true%')
            ->pluck('COLUMN_NAME');
    }
}
