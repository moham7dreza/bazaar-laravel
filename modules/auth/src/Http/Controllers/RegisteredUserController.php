<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Http\Requests\RegisterUserRequest;

final class RegisteredUserController extends Controller
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
            'password' => $request->str('password'),
            'mobile'   => $request->str('mobile'),
            'city_id'  => $request->get('city_id'),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return response()->noContent();
    }
}
