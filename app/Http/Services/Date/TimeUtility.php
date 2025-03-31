<?php

namespace App\Helpers\Date;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Jalalian;
use Illuminate\Support\Facades\Facade;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use Morilog\Jalali\CalendarUtils;

class TimeUtility extends Facade
{
    public static string $timezone = 'Asia/Tehran';

    /*
     * Return the service name or the class being resolved from the service container
     * **/
    protected static function getFacadeAccessor(): string
    {
        return 'timeUtil';
    }

    //*** ------------------------------ Jalali to Carbon ------------------------------ ***//


    /**
     * Convert a Jalali date string from a given format to a Carbon instance.
     *
     * @param string $jalaliFormattedDate Jalali date string in the given format
     *
     * @return Carbon
     */
    public static function jalaliToCarbonFromFormat(string $jalaliFormattedDate): Carbon
    {
        return Jalalian::fromFormat('Y-m-d', $jalaliFormattedDate)->toCarbon();
    }

    /**
     * Convert a Jalali date string from a given format to a string representing the date
     * in Gregorian format (YYYY-MM-DD).
     *
     * @param string $jalaliFormattedDate Jalali date string in the given format
     *
     * @return string The date in Gregorian format (YYYY-MM-DD)
     */
    public static function jalaliToCarbonFromFormatToDateString(string $jalaliFormattedDate): string
    {
        return self::jalaliToCarbonFromFormat($jalaliFormattedDate)->toDateString();
    }

    //*** ------------------------------ Carbon to Jalali ------------------------------ ***//

    /**
     * Convert a Gregorian date to Jalali date.
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    public static function carbonToJalaliFromFormat(string $date, string $format = 'Y-m-d'): string
    {
        return Jalalian::fromCarbon(Carbon::parse($date))->format($format);
    }

    //*** ------------------------------ Carbon Utilities ------------------------------ ***//

    /**
     * Get the current date and time in UTC.
     *
     * @return Carbon
     */
    public static function nowUtc(): Carbon
    {
        return Carbon::now()->utc();
    }

    /**
     * Convert a date and time string to a Carbon instance in UTC.
     *
     * @param DateTimeInterface|string|int $dateTimeString
     * @return Carbon
     */
    public static function parseCarbonToUtc(DateTimeInterface|string|int $dateTimeString): Carbon
    {
        return Carbon::parse($dateTimeString)->utc();
    }

    public static function parseCarbonFormatToUtc(string $dateTimeString, string $format = 'Y-m-d'): ?Carbon
    {
        return Carbon::createFromFormat($format, $dateTimeString)->utc();
    }

    /**
     * Get the human-readable difference between two Carbon instances.
     *
     * @param Carbon $from
     * @param Carbon|null $to (optional) defaults to current time
     *
     * @return string
     */
    public static function humanDiffFromCarbon(Carbon $from, Carbon $to = null): string
    {
        $to = $to ?: self::nowUtc();
        return $from->diffForHumans($to);
    }

    /**
     * Get the date for today, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The date for today, formatted according to $format.
     */
    public static function todayCarbonFormat(string $format = 'Y-m-d'): string
    {
        return Carbon::today()->format($format);
    }

    /**
     * Get the date for tomorrow, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The date for tomorrow, formatted according to $format.
     */
    public static function tomorrowCarbonFormat(string $format = 'Y-m-d'): string
    {
        return Carbon::tomorrow()->format($format);
    }

    /**
     * Return the current timestamp.
     *
     * @return int The current timestamp, in the format of a Unix timestamp.
     */
    public static function currentCarbonTimestamp(): int
    {
        return Carbon::now()->timestamp;
    }

    /**
     * Create a Carbon instance from a given string and format, and return its UTC timestamp.
     *
     * @param string $time
     * @param string $format (optional) The format string for parsing the input string (defaults to 'Y-m-d')
     *
     * @return float|int|string
     */
    public static function carbonTimestampFromFormat(string $time, string $format = 'Y-m-d'): float|int|string
    {
        return Carbon::createFromFormat($format, $time)->timestamp;
    }

    /**
     * Compare two timestamps, and return true if they both represent the same day.
     *
     * @param float|int|string $time1 The first timestamp to compare.
     * @param float|int|string $time2 The second timestamp to compare.
     *
     * @return bool True if the timestamps represent the same day, false otherwise.
     */
    public static function compareCarbonTimestamps(float|int|string $time1, float|int|string $time2): bool
    {
        return Carbon::createFromTimestamp($time1)->toDateString()
            ===
            Carbon::createFromTimestamp($time2)->toDateString();
    }

    //*** ------------------------------ Jalali Utilities ------------------------------ ***//

    /**
     * Convert a Gregorian date and time string to a Jalali date and time string.
     *
     * @param DateTimeInterface|string|null $date
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return ?string The Jalali date and time string, formatted according to $format.
     */
    public static function dateTimeToJalaliFormat(DateTimeInterface|string|null $date, string $format = 'Y-m-d'): ?string
    {
        return is_null($date) ? null : Jalalian::forge($date)->format($format);
    }

    /**
     * Get the Jalali date for today, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The Jalali date for today, formatted according to $format.
     */
    public static function todayJalaliFormat(string $format = 'Y-m-d'): string
    {
        return self::dateTimeToJalaliFormat('today', $format);
    }

    /**
     * Get the Jalali date for tomorrow, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The Jalali date for tomorrow, formatted according to $format.
     */
    public static function tomorrowJalaliFormat(string $format = 'Y-m-d'): string
    {
        return self::dateTimeToJalaliFormat('tomorrow', $format);
    }

    /**
     * Get the current Jalali date and time, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The current Jalali date and time, formatted according to $format.
     */
    public static function nowJalaliFormat(string $format = 'Y-m-d'): string
    {
        return self::dateTimeToJalaliFormat('now', $format);
    }

    /**
     * Get the Jalali date for yesterday, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The Jalali date for yesterday, formatted according to $format.
     */
    public static function yesterdayJalaliFormat(string $format = 'Y-m-d'): string
    {
        return self::dateTimeToJalaliFormat('yesterday', $format);
    }

    /**
     * Return a Jalali year given a number of years from the current year.
     *
     * @param int $yearsCount The number of years from the current year.
     * @param string $format (optional) The format string for the output (defaults to 'Y').
     * @return string The Jalali year, formatted according to $format.
     */
    public static function jalaliAddYearFormat(int $yearsCount, string $format = 'Y'): string
    {
        return Jalalian::now()->addYears($yearsCount)->format($format);
    }

    /**
     * Convert a Jalali datetime with the given format to timestamp.
     *
     * @param string $date A Jalali date
     * @param string $format Format of Jalali date
     * @return int Unix timestamp
     */
    public static function jalaliTimestampFromFormat(string $date, string $format = 'Y-m-d'): int
    {
        return Jalalian::fromFormat($format, $date)->getTimestamp();
    }

    /**
     * Returns true if the given date is the first day of its Jalali month.
     *
     * @param DateTimeInterface|string|int $date The date to check.
     * @return bool True if the date is the first day of its Jalali month, false otherwise.
     */
    public static function isFirstDayOfJalaliMonth(DateTimeInterface|string|int $date): bool
    {
        return Jalalian::forge($date)->format('d') === "01";
    }

    /**
     * Returns true if the given date is the last day of its Jalali month.
     *
     * @param DateTimeInterface $date The date to check.
     * @return bool True if the date is the last day of its Jalali month, false otherwise.
     */
    public static function isLastDayOfJalaliMonth(DateTimeInterface $date): bool
    {
        $clonedDate = clone $date;
        return Jalalian::forge($clonedDate->addDay())->format('d') === "01";
    }

    /**
     * Returns the Jalali season number (1-4) of the current date.
     *
     * The Jalali seasons are defined as follows:
     * 1. Spring: Farvardin (1) - Khordad (3)
     * 2. Summer: Tir (4) - Shahrivar (6)
     * 3. Autumn: Mehr (7) - Aban (8)
     * 4. Winter: Azar (9) - Esfand (12)
     *
     * @return int The Jalali season number (1-4) of the current date.
     */
    public static function jalaliSeasonNumber(DateTimeInterface|string|int $datetime): int
    {
        return (int)((Jalalian::forge($datetime)->format("m") - 1) / 3) + 1;
    }

    /**
     * Return the last day of the last Jalali month as a Carbon instance, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The last day of the last Jalali month, formatted according to $format.
     */
    public static function jalaliLastDayOfLastMonthCarbonFormat(string $format = 'Y-m-d'): string
    {
        return Jalalian::forge('now')->subDays()->toCarbon()->format($format);
    }

    /**
     * Return the first day of the last Jalali month as a Carbon instance, formatted according to the given format string.
     *
     * @param string $format (optional) The format string for the output (defaults to 'Y-m-d').
     * @return string The first day of the last Jalali month, formatted according to $format.
     */
    public static function jalaliFirstDayOfLastMonthCarbonFormat(string $format = 'Y-m-d'): string
    {
        return Jalalian::forge('now')->subMonths()->toCarbon()->format($format);
    }

    /**
     * Get the Jalali weekday name for a given timestamp.
     *
     * @param DateTimeInterface|string|int $timestamp The timestamp for which to get the Jalali weekday name.
     * @return string The Jalali weekday name for the given timestamp.
     */
    public static function jalaliWeekdayName(DateTimeInterface|string|int $timestamp): string
    {
        return Jalalian::forge($timestamp)->format('%A');
    }

    /**
     * Get the Jalali month name for a given timestamp.
     *
     * @param DateTimeInterface|string|int $timestamp The timestamp for which to get the Jalali month name.
     * @return string The Jalali month name for the given timestamp.
     */
    public static function jalaliMonthName(DateTimeInterface|string|int $timestamp): string
    {
        return Jalalian::forge($timestamp)->format('%B');
    }

    /**
     * Get the Jalali day and month name for a given timestamp.
     *
     * @param DateTimeInterface|string|int $timestamp The timestamp for which to get the Jalali day and month name.
     * @return string The Jalali day and month name for the given timestamp, in the format 'dd MMMM'.
     */
    public static function jalaliDayMonthName(DateTimeInterface|string|int $timestamp): string
    {
        return Jalalian::forge($timestamp)->format('%d %B');
    }

    /**
     * Returns a Carbon instance representing the Jalali date that is $offsetMonth months in the future,
     * with the day set to the last day of the month.
     *
     * @param int $offsetMonth The number of months to offset the current Jalali date by.
     * @param string $hourFormat
     * @return DateTime The resulting Carbon instance.
     */
    public static function jalaliDueDateFromFormat(int $offsetMonth, string $hourFormat = '12:00:00'): DateTime
    {
        $year = Jalalian::forge("now + $offsetMonth months")->format('Y');
        $month = Jalalian::forge("now + $offsetMonth months")->format('m');
        $day = app(Jalalian::class, [
            'year' => $year,
            'month' => $month,
            'day' => 1,
        ])
            ->addMonths()
            ->getMonthDays();

        return CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', "{$year}/{$month}/{$day} $hourFormat", self::$timezone);
    }

    /**
     * Return the current Jalali year number as a int.
     *
     * @return int The current Jalali year number as a int.
     */
    public static function jalaliCurrentYearNumber(): int
    {
        return (int)CalendarUtils::strftime('Y', timezone: self::$timezone);
    }

    /**
     * Return the current Jalali month number (1-31) as a int.
     *
     * @return int The current Jalali month number as a int.
     */
    public static function jalaliCurrentMonthNumber(): int
    {
        return (int)CalendarUtils::strftime('m', timezone: self::$timezone);
    }

    /**
     * Return the current Jalali day number (1-31) as an integer.
     *
     * @return int The current Jalali day number as an integer.
     */
    public static function jalaliCurrentDayNumber(): int
    {
        return (int)CalendarUtils::strftime('d', timezone: self::$timezone);
    }

    /**
     * Returns the current Jalali time as a string in the format 'Y-m-d-H-i-s', suitable for use as a filename.
     *
     * @return string The current Jalali time as a string in the format 'Y-m-d-H-i-s'.
     */
    public static function jalaliCurrentTimeAsFileName(): string
    {
        return CalendarUtils::strftime('Y-m-d-H-i-s', timezone: self::$timezone);
    }

    /**
     * Format a given timestamp according to a given Jalali date format string.
     *
     * @param DateTimeInterface|string|int $timestamp The timestamp to format, or a string in the format 'now', 'today', or 'tomorrow'.
     * @param string $format The Jalali date format string to use (defaults to 'Y-m-d').
     * @return string The formatted timestamp.
     */
    public static function jalaliFormat(DateTimeInterface|string|int $timestamp, string $format = 'Y-m-d'): string
    {
        return \Jalalian::forge($timestamp)->format($format);
    }

    /**
     * Return the current Jalali date and time, formatted according to the given format string.
     *
     * @param string $format (optional) The Jalali date format string to use (defaults to 'Y-m-d').
     * @return string The current Jalali date and time, formatted according to $format.
     */
    public static function jalaliNow(string $format = 'Y-m-d'): string
    {
        return self::jalaliFormat('now', $format);
    }

    /**
     * Return the current Jalali date, formatted according to the given format string.
     *
     * @param string $format (optional) The Jalali date format string to use (defaults to 'Y-m-d').
     * @return string The current Jalali date, formatted according to $format.
     */
    public static function jalaliToday(string $format = 'Y-m-d'): string
    {
        return self::jalaliFormat('today', $format);
    }

    /**
     * Return the Jalali date for tomorrow, formatted according to the given format string.
     *
     * @param string $format (optional) The Jalali date format string to use (defaults to 'Y-m-d').
     * @return string The Jalali date for tomorrow, formatted according to $format.
     */
    public static function jalaliTomorrow(string $format = 'Y-m-d'): string
    {
        return self::jalaliFormat('tomorrow', $format);
    }

    /**
     * Add a specified number of days to a Jalali date and return the result in the given format.
     *
     * @param string $date The input Jalali date string in the specified format.
     * @param int $days (optional) The number of days to add (defaults to 1).
     * @param string $format (optional) The Jalali date format string to use for input and output (defaults to 'Y-m-d').
     * @return string The resulting Jalali date after adding the specified number of days, formatted according to $format.
     */
    public static function jalaliAddDays(string $date, int $days = 1, string $format = 'Y-m-d'): string
    {
        return \Jalalian::fromFormat($format, $date)->addDays($days)->format($format);
    }

    /**
     * Add a specified number of months to a Jalali date and return the result in the given format.
     *
     * @param string $date The input Jalali date string in the specified format.
     * @param int $months (optional) The number of months to add (defaults to 1).
     * @param string $format (optional) The Jalali date format string to use for input and output (defaults to 'Y-m-d').
     * @return string The resulting Jalali date after adding the specified number of months, formatted according to $format.
     */
    public static function jalaliAddMonths(string $date, int $months = 1, string $format = 'Y-m-d'): string
    {
        return \Jalalian::fromFormat($format, $date)->addMonths($months)->format($format);
    }

    /**
     * Add a specified number of years to a Jalali date and return the result in the given format.
     *
     * @param string $date The input Jalali date string in the specified format.
     * @param int $years (optional) The number of years to add (defaults to 1).
     * @param string $format (optional) The Jalali date format string to use for input and output (defaults to 'Y-m-d').
     * @return string The resulting Jalali date after adding the specified number of years, formatted according to $format.
     */
    public static function jalaliAddYears(string $date, int $years = 1, string $format = 'Y-m-d'): string
    {
        return \Jalalian::fromFormat($format, $date)->addYears($years)->format($format);
    }

    //*** ------------------------------ helpers ------------------------------ ***//

    /**
     * Check if a given timestamp is in the past.
     *
     * @param int $timestamp
     * @return bool
     */
    public static function isPast(int $timestamp): bool
    {
        return $timestamp < time();
    }

    /**
     * Check if a given timestamp is in the future.
     *
     * @param int $timestamp
     * @return bool
     */
    public static function isFuture(int $timestamp): bool
    {
        return $timestamp > time();
    }

    /*
    * Mongo Section
    ***/

    //*** ------------------------------ Mongo DateTime To Carbon ------------------------------ ***//

    /**
     * Convert a MongoDB UTCDateTime to a Carbon instance.
     *
     * @param UTCDateTime $date
     * @return Carbon
     */
    public static function convertMongoUTCDateTimeToCarbon(UTCDateTime $date): Carbon
    {
        return Carbon::createFromTimestamp(self::getMongoTimestamp($date))->setTimeZone(self::$timezone);
    }

    /**
     * Convert a MongoDB ObjectId to a Carbon instance.
     *
     * @param string $id The ObjectId as a string.
     * @return Carbon
     */
    public static function convertMongoObjectIdToCarbon(string $id): Carbon
    {
        return Carbon::createFromTimestamp((new ObjectId($id))->getTimestamp())->setTimeZone(self::$timezone);
    }

    //*** ------------------------------ Carbon To Mongo DateTime ------------------------------ ***//

    /**
     * Convert a given datetime string to a MongoDB UTCDateTime instance.
     *
     * The given datetime string should be in the format 'Y-m-d', and should be in the application's timezone.
     *
     * @param string $date
     * @param string $format
     * @return UTCDateTime
     */
    public static function convertCarbonFormatToMongoUTCDateTime(string $date, string $format = 'Y-m-d H:i:s'): UTCDateTime
    {
        return new UTCDateTime(Carbon::createFromFormat($format, $date)->setTimeZone(self::$timezone)->getTimestampMs());
    }

    /**
     * Convert a Carbon date string to a MongoDB UTCDateTime instance.
     *
     * The provided date string is parsed into a Carbon instance, adjusted to the application's timezone,
     * and then formatted as a UTCDateTime.
     *
     * @param DateTimeInterface|string|int $date The date string to be converted.
     * @return UTCDateTime The corresponding MongoDB UTCDateTime instance.
     */
    public static function convertCarbonToMongoUTCDateTime(DateTimeInterface|string|int $date): UTCDateTime
    {
        return new UTCDateTime(Carbon::parse($date)->setTimeZone(self::$timezone)->getTimestampMs());
    }

    /**
     * Convert a Carbon date string to a MongoDB ObjectId.
     *
     * The provided date string is parsed into a Carbon instance, and its timestamp is extracted.
     * A new ObjectId is created with the timestamp as its hexadecimal representation,
     * padded with zeroes to get 24 characters.
     *
     * @param DateTimeInterface|string|int $date The date string to be converted.
     * @return ObjectId The corresponding MongoDB ObjectId.
     */
    public static function convertCarbonToMongoObjectId(DateTimeInterface|string|int $date): ObjectId
    {
        $timestamp = Carbon::parse($date)->setTimeZone(self::$timezone)->getTimestamp();

        $hexTimestamp = dechex($timestamp);
        $objectIdHex = str_pad($hexTimestamp, 8, '0', STR_PAD_LEFT) . str_repeat('0', 16); // pad with zeroes to get 24 chars

        return new ObjectId($objectIdHex);
    }

    //*** ------------------------------ Mongo Utilities ------------------------------ ***//

    /**
     * Returns the current datetime in the application's timezone as a MongoDB UTCDateTime instance.
     *
     * This is equivalent to calling `convertCarbonToMongoUTCDateTime` with the result of `now()` as the argument.
     *
     * @return UTCDateTime
     */
    public static function getCurrentMongoDateTime(): UTCDateTime
    {
        return self::convertCarbonToMongoUTCDateTime(now());
    }

    /**
     * Extracts the timestamp (in seconds) from a MongoDB UTCDateTime instance.
     *
     * @param UTCDateTime $date The MongoDB UTCDateTime instance to extract the timestamp from.
     * @return int The timestamp, in seconds.
     */
    public static function getMongoTimestamp(UTCDateTime $date): int
    {
        return $date->toDateTime()->getTimestamp();
    }

    /**
     * @return int
     */
    public static function getDaysInMonth(): int
    {
        return 30;
    }
}
