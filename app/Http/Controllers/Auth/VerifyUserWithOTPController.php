<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use App\Models\User\Otp;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerifyUserWithOTPController extends Controller
{
    public function store(VerifyOtpRequest $request): JsonResponse
    {
        $otp = Otp::query()->firstWhere([
            'token' => $request->token,
            'login_id' => $request->mobile,
            'used' => 0,
        ]);

        if (! $otp) {
            return ApiJsonResponse::error('کد تایید یافت نشد', code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($otp->attempts >= 3) {
            return ApiJsonResponse::error('تعداد دفعات مجاز این کد به پایان رسید', code: Response::HTTP_TOO_MANY_REQUESTS);
        }

        if (Carbon::now()->diffInMinutes($otp->created_at) > 5) {
            return ApiJsonResponse::error('زمان مجاز این کد به پایان رسید', code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($otp->otp_code !== $request->otp) {

            $otp->increment('attempts');

            return ApiJsonResponse::error('کد وارد شده صحیح نمیباشد', code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otp->update(['used' => 1]);

        $user = User::firstWhere('mobile', $request->mobile);

        if (! $user) {

            $user = User::create([
                'password' => Hash::make(Str::random(10)),
                'mobile' => $request->mobile,
                'city_id' => $request->city_id,
                'mobile_verified_at' => now(),
            ]);

            $message = 'ثبت نام و ورود با موفقیت انجام شد';
        } else {

            $message = 'با موفقیت وارد شدید';
        }

        event(new Registered($user));

        auth()->login($user);

        return ApiJsonResponse::success($message);
    }
}
