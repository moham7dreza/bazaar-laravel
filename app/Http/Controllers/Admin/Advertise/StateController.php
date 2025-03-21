<?php

namespace App\Http\Controllers\Admin\Advertise;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStateRequest;
use App\Http\Requests\Admin\UpdateStateRequest;
use App\Http\Resources\Admin\Advertise\StateCollection;
use App\Http\Resources\Admin\Advertise\StateResource;
use App\Models\Advertise\State;

class StateController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new StateCollection(State::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        $inputs = $request->all();
        $state = State::create($inputs);
        return new StateResource($state);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        return new StateResource($state);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state)
    {
        $inputs = $request->all();
        $state->update($inputs);
        return new StateResource($state);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $state->delete();
        return $this->success(null, 'محل حذف شد');
    }
}
