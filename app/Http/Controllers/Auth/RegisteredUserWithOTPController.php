<?php

namespace App\Http\Controllers\Auth;

use Amiriun\SMS\DataContracts\SendSMSDTO;
use Amiriun\SMS\Services\SMSService;
use App\Enums\NoticeType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginOtpRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Timebox;
use Random\RandomException;

class RegisteredUserWithOTPController extends Controller
{
    /**
     * @throws \Throwable
     * @throws RandomException
     */
    public function __invoke(LoginOtpRequest $request, SmsService $smsService): JsonResponse
    {
        $user = User::firstWhere('mobile', $request->mobile);

        return (new Timebox)->call(function () use ($user, $request, $smsService) {

            $otpCode = random_int(1000, 9999);
            $token   = Str::random(60);

            Otp::query()->updateOrCreate(
                ['login_id' => $request->mobile, 'used' => 0],
                [
                    'token'    => $token,
                    'otp_code' => $otpCode,
                    'login_id' => $request->mobile,
                    'type'     => NoticeType::SMS,
                    'attempts' => 0,
                    'user_id'  => $user?->id,
                ]
            );

            $data = new SendSMSDTO;
            $data->setSenderNumber('300024444');
            $data->setMessage($otpCode);
            $data->setTo($request->mobile);

            $smsService->send($data);

            return ApiJsonResponse::success(['token' => $token], message: 'کد تایید با موفقیت ارسال شد');
        }, 200000);
    }
}
