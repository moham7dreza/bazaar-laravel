<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Models\State;
use Throwable;

final class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index(): ResourceCollection
    {
        return State::query()
            ->whereNull('parent_id')
            ->paginate(10)
            ->toResourceCollection();
    }
}
