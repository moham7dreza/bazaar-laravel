<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateNationalCodeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nationalCode = $value;

        $nationalCode = mb_trim($nationalCode, ' .');
        $nationalCode = convertArabicToEnglish($nationalCode);
        $nationalCode = convertPersianToEnglish($nationalCode);
        $bannedArray  = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];

        if (empty($nationalCode))
        {

            $fail(trans('validation.national_code', ['attribute' => $attribute]));

        } elseif (10 !== count(mb_str_split($nationalCode)))
        {

            $fail(trans('validation.national_code', ['attribute' => $attribute]));

        } elseif (in_array($nationalCode, $bannedArray, true))
        {

            $fail(trans('validation.national_code', ['attribute' => $attribute]));

        } else
        {

            $sum = 0;

            for ($i = 0; $i < 9; $i++)
            {
                // 1234567890
                $sum += (int) $nationalCode[$i] * (10 - $i);
            }

            $divideRemaining = $sum % 11;

            if ($divideRemaining < 2)
            {
                $lastDigit = $divideRemaining;
            } else
            {
                $lastDigit = 11 - ($divideRemaining);
            }

            if ((int) \Illuminate\Support\Arr::get($nationalCode, 9) !== $lastDigit)
            {
                $fail(trans('validation.national_code', ['attribute' => $attribute]));
            }
        }
    }
}
