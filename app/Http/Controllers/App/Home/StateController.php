<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\StateCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Advertise\Models\State;

final class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $states = State::query()->whereNull('parent_id')->get();

        return $states->toResourceCollection(StateCollection::class);
    }
}
