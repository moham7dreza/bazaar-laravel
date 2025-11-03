<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Advertise\Http\Requests\Admin\StoreStateRequest;
use Modules\Advertise\Http\Requests\Admin\UpdateStateRequest;
use Modules\Advertise\Http\Resources\Admin\StateResource;
use Modules\Advertise\Models\State;
use Throwable;

final class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return State::query()->paginate()->toResourceCollection(StateResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        $inputs = $request->all();
        $state  = State::query()->create($inputs);

        return $state->toResource(StateResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        return $state->toResource(StateResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state)
    {
        $inputs = $request->all();
        $state->update($inputs);

        return $state->toResource(StateResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $state->delete();

        return ApiJsonResponse::success(message:  'محل حذف شد');
    }
}
