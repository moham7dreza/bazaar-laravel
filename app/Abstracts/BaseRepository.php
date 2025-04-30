<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Builder
 */
abstract class BaseRepository
{
    private Builder $query;

    /**
     * Save the model to the database.
     */
    public function save(Model $model): void
    {
        $model->save();
    }

    abstract protected function baseQuery(): Builder;

    final protected function freshQuery(): self
    {
        $this->query = $this->baseQuery();

        return $this;
    }

    /**
     * @return T
     */
    final protected function getQuery(): Builder
    {
        return $this->query;
    }
}
