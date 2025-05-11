<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Content\Models\Page;
use PageCollection;
use PageResource;
use StorePageRequest;
use UpdatePageRequest;

final class PageController extends Controller
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
        $page   = Page::create($inputs);

        return new PageResource($page);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return new PageResource($page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $inputs = $request->all();
        $page->update($inputs);

        return new PageResource($page);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return ApiJsonResponse::success(message: 'منو حذف شد');
    }
}
