<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\Date;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use Morilog\Jalali\CalendarUtils;

final class TimeUtility
{
    public static function isFirstDayOfJalaliMonth(DateTimeInterface|string|int|null $date): bool
    {
        return '01' === JalalianFactory::fromGregorian($date)?->format('d');
    }

    public static function isLastDayOfJalaliMonth(DateTimeInterface|string|int|null $date): bool
    {
        $clonedDate = clone $date;

        return '01' === JalalianFactory::fromGregorian($clonedDate->addDay())?->format('d');
    }

    public static function jalaliSeasonNumber(DateTimeInterface|string|int|null $date): ?int
    {
        return null === $date ? null : (int) ((jdate($date)->format('m') - 1) / 3) + 1;
    }

    public static function jalaliWeekdayName(DateTimeInterface|string|int|null $date): ?string
    {
        return JalalianFactory::fromGregorian($date)?->format('%A');
    }

    public static function jalaliMonthName(DateTimeInterface|string|int|null $date): ?string
    {
        return JalalianFactory::fromGregorian($date)?->format('%B');
    }

    public static function jalaliDayMonthName(DateTimeInterface|string|int|null $date): ?string
    {
        return JalalianFactory::fromGregorian($date)?->format('%d %B');
    }

    public static function jalaliCurrentYearNumber(): int
    {
        return (int) CalendarUtils::strftime('Y');
    }

    public static function jalaliCurrentMonthNumber(): int
    {
        return (int) CalendarUtils::strftime('m');
    }

    public static function jalaliCurrentDayNumber(): int
    {
        return (int) CalendarUtils::strftime('d');
    }

    public static function jalaliCurrentTimeAsFileName(): string
    {
        return CalendarUtils::strftime('Y_m_d_H_i_s');
    }

    public static function convertMongoUTCDateTimeToCarbon(UTCDateTime $date): Carbon
    {
        return Date::createFromTimestamp(self::getMongoTimestamp($date));
    }

    public static function convertMongoObjectIdToCarbon(string $id): Carbon
    {
        return Date::createFromTimestamp(new ObjectId($id)->getTimestamp());
    }

    public static function convertCarbonFormatToMongoUTCDateTime(string $date, string $format = 'Y-m-d H:i:s'): UTCDateTime
    {
        return new UTCDateTime(Date::createFromFormat($format, $date)?->getTimestampMs());
    }

    public static function convertCarbonToMongoUTCDateTime(DateTimeInterface|string|int $date): UTCDateTime
    {
        return new UTCDateTime(Date::parse($date)->getTimestampMs());
    }

    public static function convertCarbonToMongoObjectId(DateTimeInterface|string|int $date): ObjectId
    {
        $timestamp = Date::parse($date)->getTimestamp();

        $hexTimestamp = dechex($timestamp);
        $objectIdHex  = mb_str_pad($hexTimestamp, 8, '0', STR_PAD_LEFT) . str_repeat('0', 16); // pad with zeroes to get 24 chars

        return new ObjectId($objectIdHex);
    }

    public static function getMongoTimestamp(UTCDateTime $date): int
    {
        return $date->toDateTime()->getTimestamp();
    }
}
