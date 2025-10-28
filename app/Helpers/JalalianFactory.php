<?php

declare(strict_types=1);

namespace App\Helpers;

use DateTimeInterface;
use Morilog\Jalali\Jalalian;
use RuntimeException;

final readonly class JalalianFactory
{
    /**
     * Create a new Jalalian instance from a DateTimeInterface, Gregorian date string, or timestamp.
     *
     * @param  DateTimeInterface|string|int|null  $date  Must NOT be a Jalalian instance.
     *
     * @throws RuntimeException If $date is a Jalalian instance or unsupported type.
     */
    public static function fromGregorian(mixed $date): ?Jalalian
    {
        throw_if(null !== $date && ! is_string($date) && ! is_int($date) && ! ($date instanceof DateTimeInterface), RuntimeException::class, '$date must be a string, int, or DateTimeInterface instance.');

        return filled($date) ? jdate($date) : null;
    }

    /**
     * Create a new Jalalian instance from a Jalali (Shamsi) date string.
     */
    public static function fromJalali(string|null $date, string $format = 'Y-m-d'): ?Jalalian
    {
        return filled($date) ? Jalalian::fromFormat($format, $date) : null;
    }

    /**
     * Create a new Jalalian instance with the current datetime.
     */
    public static function now(): Jalalian
    {
        return self::fromGregorian('now');
    }
}
