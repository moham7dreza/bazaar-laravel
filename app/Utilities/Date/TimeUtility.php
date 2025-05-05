<?php

namespace App\Utilities\Date;

use Carbon\Carbon;
use DateTimeInterface;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use Morilog\Jalali\CalendarUtils;

final class TimeUtility
{
    public static function isFirstDayOfJalaliMonth(DateTimeInterface|string|int|null $date): bool
    {
        return jalali_date($date)?->format('d') === '01';
    }

    public static function isLastDayOfJalaliMonth(DateTimeInterface|string|int|null $date): bool
    {
        $clonedDate = clone $date;

        return jalali_date($clonedDate->addDay())?->format('d') === '01';
    }

    public static function jalaliSeasonNumber(DateTimeInterface|string|int|null $date): ?int
    {
        return is_null($date) ? null : (int) ((jdate($date)->format('m') - 1) / 3) + 1;
    }

    public static function jalaliWeekdayName(DateTimeInterface|string|int|null $date): ?string
    {
        return jalali_date($date)?->format('%A');
    }

    public static function jalaliMonthName(DateTimeInterface|string|int|null $date): ?string
    {
        return jalali_date($date)?->format('%B');
    }

    public static function jalaliDayMonthName(DateTimeInterface|string|int|null $date): ?string
    {
        return jalali_date($date)?->format('%d %B');
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
        return CalendarUtils::strftime('Y-m-d-H-i-s');
    }

    public static function convertMongoUTCDateTimeToCarbon(UTCDateTime $date): Carbon
    {
        return Carbon::createFromTimestamp(self::getMongoTimestamp($date));
    }

    public static function convertMongoObjectIdToCarbon(string $id): Carbon
    {
        return Carbon::createFromTimestamp((new ObjectId($id))->getTimestamp());
    }

    public static function convertCarbonFormatToMongoUTCDateTime(string $date, string $format = 'Y-m-d H:i:s'): UTCDateTime
    {
        return new UTCDateTime(Carbon::createFromFormat($format, $date)?->getTimestampMs());
    }

    public static function convertCarbonToMongoUTCDateTime(DateTimeInterface|string|int $date): UTCDateTime
    {
        return new UTCDateTime(Carbon::parse($date)->getTimestampMs());
    }

    public static function convertCarbonToMongoObjectId(DateTimeInterface|string|int $date): ObjectId
    {
        $timestamp = Carbon::parse($date)->getTimestamp();

        $hexTimestamp = dechex($timestamp);
        $objectIdHex  = str_pad($hexTimestamp, 8, '0', STR_PAD_LEFT).str_repeat('0', 16); // pad with zeroes to get 24 chars

        return new ObjectId($objectIdHex);
    }

    public static function getMongoTimestamp(UTCDateTime $date): int
    {
        return $date->toDateTime()->getTimestamp();
    }
}
