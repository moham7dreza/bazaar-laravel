<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Resources\Admin\Content\PageCollection;
use App\Http\Resources\Admin\Content\PageResource;
use App\Models\Content\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PageCollection(Page::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        $inputs = $request->all();
        $page = Page::create($inputs);
        return new PageResource($page);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
