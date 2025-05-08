<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function __invoke(RegisterUserRequest $request): Response
    {
        $user = User::create([
            'name'     => $request->str('name'),
            'email'    => $request->str('email'),
            'password' => Hash::make($request->str('password')),
            'mobile'   => $request->str('mobile'),
            'city_id'  => $request->get('city_id'),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return response()->noContent();
    }
}
