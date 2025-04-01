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
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     public function store(Request $request): Response
     {

         $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'mobile' => ['required', 'string', 'max:15', 'unique:' . User::class],
             'city_id' => ['nullable', 'exists:cities,id'],
         ]);

         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'mobile' => $request->mobile,
             'city_id' => $request->city_id,
         ]);

         event(new Registered($user));

         Auth::login($user);

         return response()->noContent();
     }
}
