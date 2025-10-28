<?php

declare(strict_types=1);

namespace App\Actions\Abstracts;

abstract class Action
{
    abstract public function handle(): mixed;

    public static function dispatch(mixed ...$params): mixed
    {
        $action = static::make(...$params);

        if ($action->authorize())
        {
            return $action->handle();
        }

        return null;
    }

    public static function make(mixed ...$params): static
    {
        return new static(...$params);
    }

    public function authorize(): bool
    {
        return true;
    }
}
