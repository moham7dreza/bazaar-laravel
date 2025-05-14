<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Http\Resources\App\StateResource;
use Modules\Advertise\Models\State;

final class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $states = State::query()->whereNull('parent_id')->get();

        return $states->toResourceCollection(StateResource::class);
    }
}
