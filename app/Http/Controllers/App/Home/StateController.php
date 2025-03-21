<?php

namespace App\Http\Controllers\App\Home;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\StateCollection;
use App\Models\Advertise\State;

class StateController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new StateCollection(State::whereNull('parent_id')->get());
    }
}
