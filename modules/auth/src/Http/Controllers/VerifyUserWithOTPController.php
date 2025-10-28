<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Modules\Auth\Http\Requests\VerifyOtpRequest;
use Modules\Auth\Models\Otp;

final class VerifyUserWithOTPController extends Controller
{
    public function __invoke(VerifyOtpRequest $request): JsonResponse
    {
        $otp = Otp::query()->firstWhere([
            'token'    => $request->token,
            'login_id' => $request->mobile,
            'used'     => 0,
        ]);

        if ( ! $otp)
        {
            return ApiJsonResponse::error(Response::HTTP_UNPROCESSABLE_ENTITY, 'کد تایید یافت نشد');
        }

        if ($otp->attempts >= 3)
        {
            return ApiJsonResponse::error(Response::HTTP_TOO_MANY_REQUESTS, 'تعداد دفعات مجاز این کد به پایان رسید');
        }

        if (Date::now()->diffInMinutes($otp->created_at) > 5)
        {
            return ApiJsonResponse::error(Response::HTTP_UNPROCESSABLE_ENTITY, 'زمان مجاز این کد به پایان رسید');
        }

        if ($otp->otp_code !== $request->otp)
        {

            $otp->increment('attempts');

            return ApiJsonResponse::error(Response::HTTP_UNPROCESSABLE_ENTITY, 'کد وارد شده صحیح نمیباشد');
        }

        $otp->update(['used' => 1]);

        $user = User::query()->firstWhere('mobile', $request->mobile);

        if ( ! $user)
        {

            $user = User::query()->create([
                'password'           => Str::random(10),
                'mobile'             => $request->mobile,
                'city_id'            => $request->city_id,
                'mobile_verified_at' => now(),
                'email'              => fake()->email,
            ]);

            $message = 'ثبت نام و ورود با موفقیت انجام شد';
        } else
        {

            $message = 'با موفقیت وارد شدید';
        }

        event(new Registered($user));

        auth()->login($user);

        return ApiJsonResponse::success(message: $message);
    }
}
