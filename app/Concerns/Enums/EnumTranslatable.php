<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

use Illuminate\Support\Arr;

trait EnumTranslatable
{
    use EnumArrayable;

    /**
     * Get enum Arrayable as translation.
     */
    public static function toArrayTrans(): array
    {
        $cases = [];

        foreach (self::values() as $value)
        {
            $cases[] = [
                'value' => $value,
                'name'  => __(static::getTransKey() . ".{$value}"),
            ];
        }

        return $cases;
    }

    /**
     * Get enum trans key.
     */
    /**
     * Get enum trans key with namespace.
     */
    public static function getTransKey(): string
    {
        $namespace = static::getTranslationNamespace();
        $key       = str(mb_rtrim(class_basename(static::class), 'Enum'))->snake()->plural();

        return $namespace ? "{$namespace}::enums.{$key}" : "enums.{$key}";
    }

    /**
     * Get enum as an array value with trans.
     */
    public function object(): array
    {
        return [
            'value' => $this->value,
            'name'  => $this->trans(),
        ];
    }

    /**
     * Trans enum value.
     */
    public function trans(?string $locale = null): string
    {
        return __($this->transKey(), [], $locale);
    }

    /**
     * Trans key for enum value.
     */
    public function transKey(): string
    {
        return static::getTransKey() . ".{$this->value}";
    }

    /**
     * Return all translations for the enum case.
     */
    public function allTrans(): array
    {
        return array_reduce(config()->array('app.available_locales'), function ($result, $locale) {
            $result[$locale] = $this->trans($locale);

            return $result;
        });
    }

    /**
     * Get the translation namespace (module or default).
     */
    protected static function getTranslationNamespace(): ?string
    {
        return self::resolveModuleNamespace(static::class);
    }

    /**
     * Resolve the module namespace from enum class
     * Override this method to customize module detection.
     */
    protected static function resolveModuleNamespace(string $enumClass): ?string
    {
        // Default implementation for nWidart/laravel-modules
        // Pattern: Modules\{ModuleName}\...
        if (preg_match('/\\\\Modules\\\\([^\\\\]+)\\\\/', $enumClass, $matches))
        {
            return mb_strtolower((string) Arr::get($matches, 1));
        }

        return null;
    }
}
