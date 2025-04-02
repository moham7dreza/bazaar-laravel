<?php

use App\Enums\Environment;
use App\Jobs\MongoLogJob;
use App\Models\Monitor\DevLog;
use Illuminate\Database\Eloquent\Builder;
use Morilog\Jalali\Jalalian;

function jalaliDate($date, string $format = '%A, %d %B %Y'): string
{
    return convertEnglishToPersian(Jalalian::forge($date)->format($format));
}

function convertPersianToEnglish($number): array|string
{
    $number = str_replace('۰', '0', $number);
    $number = str_replace('۱', '1', $number);
    $number = str_replace('۲', '2', $number);
    $number = str_replace('۳', '3', $number);
    $number = str_replace('۴', '4', $number);
    $number = str_replace('۵', '5', $number);
    $number = str_replace('۶', '6', $number);
    $number = str_replace('۷', '7', $number);
    $number = str_replace('۸', '8', $number);

    return str_replace('۹', '9', $number);
}

function convertArabicToEnglish($number): array|string
{
    $number = str_replace('۰', '0', $number);
    $number = str_replace('۱', '1', $number);
    $number = str_replace('۲', '2', $number);
    $number = str_replace('۳', '3', $number);
    $number = str_replace('۴', '4', $number);
    $number = str_replace('۵', '5', $number);
    $number = str_replace('۶', '6', $number);
    $number = str_replace('۷', '7', $number);
    $number = str_replace('۸', '8', $number);

    return str_replace('۹', '9', $number);
}

function convertEnglishToPersian($number): array|string
{
    $number = str_replace('0', '۰', $number);
    $number = str_replace('1', '۱', $number);
    $number = str_replace('2', '۲', $number);
    $number = str_replace('3', '۳', $number);
    $number = str_replace('4', '۴', $number);
    $number = str_replace('5', '۵', $number);
    $number = str_replace('6', '۶', $number);
    $number = str_replace('7', '۷', $number);
    $number = str_replace('8', '۸', $number);

    return str_replace('9', '۹', $number);
}

/**
 * @return array|string|string[]
 */
function priceFormat($price): array|string
{
    $price = number_format($price, 0, '/', '،');

    return convertEnglishToPersian($price);
}

function validateNationalCode($nationalCode): bool
{
    $nationalCode = trim($nationalCode, ' .');
    $nationalCode = convertArabicToEnglish($nationalCode);
    $nationalCode = convertPersianToEnglish($nationalCode);
    $bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];

    if (empty($nationalCode)) {
        return false;
    } elseif (count(str_split($nationalCode)) != 10) {
        return false;
    } elseif (in_array($nationalCode, $bannedArray)) {
        return false;
    } else {

        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            // 1234567890
            $sum += (int)$nationalCode[$i] * (10 - $i);
        }

        $divideRemaining = $sum % 11;

        if ($divideRemaining < 2) {
            $lastDigit = $divideRemaining;
        } else {
            $lastDigit = 11 - ($divideRemaining);
        }

        if ((int)$nationalCode[9] == $lastDigit) {
            return true;
        } else {
            return false;
        }

    }
}

function convert($size, $unit): array|string
{
    $fileSize = 0;

    if ($unit == 'Byte') {
        $fileSize = round($size, 4);
        if ($fileSize > 1024) {
            convert($fileSize, 'KB');
        } else {
            return convertEnglishToPersian($fileSize) . ' بایت ';
        }
    } elseif ($unit == 'KB') {
        $fileSize = round($size / 1024, 4);
        if ($fileSize > 1024) {
            convert($fileSize, 'MB');
        } else {
            return convertEnglishToPersian($fileSize) . ' کیلوبایت ';
        }
    } elseif ($unit == 'MB') {
        $fileSize = round($size / 1024 / 1024, 4);
        if ($fileSize > 1024) {
            convert($fileSize, 'GB');
        } else {
            return convertEnglishToPersian($fileSize) . ' مگابایت ';
        }
    } elseif ($unit == 'GB') {
        $fileSize = round($size / 1024 / 1024 / 1024, 4);

        return convertEnglishToPersian($fileSize) . ' گیگابایت ';
    }

    return convertEnglishToPersian($fileSize);
}

if (!function_exists('get_value_enums')) {
    /**
     * Get value from enums file.
     */
    function get_value_enums(array $data): array
    {
        $values = [];

        foreach ($data as $value) {
            $values[] = $value->value;
        }

        return $values;
    }
}

if (!function_exists('startWith')) {
    /**
     * Check start with character.
     */
    function startWith(string $string, string $startString): bool
    {
        return str_starts_with($string, $startString);
    }
}

if (!function_exists('router')) {
    /**
     * Check start with character.
     */
    function router(string $key): string
    {
        return route(config($key));
    }
}

if (!function_exists('getUser')) {
    function getUser($request = null)
    {
        if (is_null($request)) {
            $request = request();
        }

        return $request->user();
    }
}
if (!function_exists('getRandomArray')) {
    function getRandomArray(int $count = 5): array
    {
        return collect()
            ->times($count)
            ->map(fn() => fake()->name)
            ->all();
    }
}

if (!function_exists('is_array_filled')) {
    function is_array_filled(array $array): bool
    {
        return collect(array_values($array))->filter()->count() > 0;
    }
}

if (!function_exists('getImageList')) {
    function getImageList($image): array|string
    {
        $images = is_string($image) ? [$image] : $image;

        return is_array($images)
            ? collect($images)->map(fn($path) => asset($path))->unique()->toArray()
            : asset($images);
    }

}


if (!function_exists('ondemand_info')) {
    function ondemand_info(string $message, array $context = [], string $file = 'custom'): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/' . $file . '.log'),
            'level' => 'info',
        ])->info($message, $context);
    }
}

if (!function_exists('mongo_info')) {
    function mongo_info($log_key, $data, $queueable = false): void
    {
        if(!$data || isEnvTesting()){
            return;
        }
        try {
            $dispatch = $queueable ? 'dispatch' : 'dispatchSync';

            MongoLogJob::$dispatch($data, $log_key);
        } catch (\Exception $exception) {
            //
        }
    }
}

if (!function_exists('isEnvTesting')) {
    function isEnvTesting(): bool
    {
        return app()->environment(Environment::TESTING->value);
    }
}

if (!function_exists('isEnvLocal')) {
    function isEnvLocal(): bool
    {
        return app()->environment(Environment::local());
    }
}

if (!function_exists('isEnvStaging')) {
    function isEnvStaging(): bool
    {
        return app()->environment(Environment::STAGING->value);
    }
}

if (!function_exists('isEnvProduction')) {
    function isEnvProduction(): bool
    {
        return app()->environment(Environment::PRODUCTION->value);
    }
}

if (!function_exists('isEnvLocalOrTesting')) {
    function isEnvLocalOrTesting(): bool
    {
        return app()->environment(Environment::localOrTesting());
    }
}

function number2latin($str): array|string
{

    $western_arabic = array('0', '0', '1', '1', '2', '2', '3', '3', '4', '4', '5', '5', '6', '6', '7', '7', '8', '8', '9', '9');
    $eastern_arabic = array('٠', '۰', '۱', '١', '٢', '۲', '٣', '۳', '٤', '۴', '٥', '۵', '٦', '۶', '٧', '۷', '٨', '۸', '٩', '۹');

    return str_replace($eastern_arabic, $western_arabic, $str);
}

if (!function_exists('getSqlWithBindings')) {
    function getSqlWithBindings(Builder $query): array
    {
        return str_replace('?', $query->getBindings(), $query->toSql());
    }
}
