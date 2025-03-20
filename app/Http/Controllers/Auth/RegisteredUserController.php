<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Sms\SmsService;
use App\Models\User\Otp;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{


    public function sendOtp(Request $request, SmsService $smsService)
    {
        $request->validate([
            'mobile' => ['required', 'string', 'max:15']
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

        $smsService->sendSmsOtp($request->mobile, $otpCode);

        return response()->json([
            'message' => 'کد تایید با موفقیت ارسال شد',
            'token' => $token,
        ], 200);
    }


    public function verifyOtpAndRegister(Request $request)
    {

        $request->validate([
            'mobile' => ['required', 'string', 'max:15'],
            'otp' => ['required', 'string', 'size:4'],
            'token' => ['required', 'string'],
        ]);


        $otp = Otp::where('token', $request->token)->where('login_id', $request->mobile)->where('used', 0)->first();

        if (!$otp) {
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

        //login
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




    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): Response
    // {

    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //         'mobile' => ['required', 'string', 'max:15', 'unique:' . User::class],
    //         'city_id' => ['required', 'exists:cities,id'],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'mobile' => $request->mobile,
    //         'city_id' => $request->city_id,
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return response()->noContent();
    // }
}
