<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Resources\Admin\User\UserCollection;
use App\Http\Resources\Admin\User\UserResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserCollection(User::all());
    }

    /**
     * store new user from admin panel.
     */
    public function store(StoreUserRequest $request)
    {
        $request->merge([
            'mobile_verified_at' => $request->has('is_active') ? now() : null,
            'email_verified_at'  => $request->has('is_active') ? now() : null,
        ]);

        return User::query()
            ->create($request->validated())
            ->toResource(UserResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $inputs = ['name' => $request->name];
        $user->update($inputs);

        return new UserResource($user);
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
