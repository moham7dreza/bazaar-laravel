<?php

namespace App\Http\Controllers\Auth;

use Amiriun\SMS\Services\SMSService;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisteredUserWithOTPController extends Controller
{
    public function store(Request $request, SmsService $smsService)
    {
        $request->validate([
            'mobile' => ['required', 'string', 'max:15'],
        ]);

        $otpCode = random_int(1000, 9999);
        $token = Str::random(60);

        $user = User::where('mobile', $request->mobile)->first();

        Otp::updateOrCreate(
            ['login_id' => $request->mobile, 'used' => 0],
            [
                'token' => $token,
                'otp_code' => $otpCode,
                'login_id' => $request->mobile,
                'type' => 0,
                'attempts' => 0,
                'user_id' => $user ? $user->id : null,
            ]
        );

        $data = new \Amiriun\SMS\DataContracts\SendSMSDTO;
        $data->setSenderNumber('300024444'); // also this can be set as default in config/sms.php
        $data->setMessage($otpCode);
        $data->setTo($request->mobile);

        app(SMSService::class)->send($data);

        return response()->json([
            'message' => 'کد تایید با موفقیت ارسال شد',
            'token' => $token,
        ], 200);
    }
}
