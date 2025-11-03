<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return User::query()->paginate()->toResourceCollection();
    }

    /**
     * store new user from admin panel.
     */
    public function store(StoreUserRequest $request)
    {
        $request->merge([
            'mobile_verified_at' => $request->has('is_active') ? Date::now() : null,
            'email_verified_at'  => $request->has('is_active') ? Date::now() : null,
        ]);

        return User::query()
            ->create($request->validated())
            ->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $inputs = ['name' => $request->name];
        $user->update($inputs);

        return $user->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return ApiJsonResponse::success(message: 'کاربر حذف شد');
    }
}
