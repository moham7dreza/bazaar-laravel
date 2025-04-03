<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Otp;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerifyUserWithOTPController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'mobile' => ['required', 'string', 'max:15'],
            'otp' => ['required', 'string', 'size:4'],
            'token' => ['required', 'string'],
        ]);

        $otp = Otp::where('token', $request->token)->where('login_id', $request->mobile)->where('used', 0)->first();

        if (! $otp) {
            return response()->json([
                'message' => 'کد تایید یافت نشد',
            ], 422);
        }

        if ($otp->attempts >= 3) {
            return response()->json([
                'message' => 'تعداد دفعات مجاز این کد به پایان رسید',
            ], status: 429);
        }

        if (Carbon::now()->diffInMinutes($otp->created_at) > 5) {
            return response()->json([
                'message' => 'زمان  مجاز این کد به پایان رسید',
            ], status: 422);
        }

        if ($otp->otp_code !== $request->otp) {
            $otp->increment('attempts');

            return response()->json([
                'message' => 'کد وارد شده صحیح نمیباشد',
            ], status: 422);
        }

        $otp->update(['used' => 1]);

        $user = User::where('mobile', $request->mobile)->first();

        // login
        if ($user) {
            Auth::login($user);

            return response()->json([
                'message' => 'با موفقیت وارد شدید',
            ], status: 200);
        }

        // register and login
        else {
            $user = User::create([
                'password' => Hash::make(Str::random(10)),
                'mobile' => $request->mobile,
                'city_id' => $request->city_id,
                'mobile_verified_at' => now(),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return response()->json([
                'message' => 'ثبت نام و ورود با موفقیت انجام شد',
            ], status: 200);
        }
    }
}
