<?php

declare(strict_types=1);

namespace Modules\Content\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Modules\Content\Http\Requests\Admin\StorePageRequest;
use Modules\Content\Http\Requests\Admin\UpdatePageRequest;
use Modules\Content\Http\Resources\Admin\PageResource;
use Modules\Content\Models\Page;
use Throwable;

final class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws Throwable
     */
    public function index()
    {
        return Page::query()->paginate()->toResourceCollection(PageResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        $inputs = $request->all();
        $page   = Page::query()->create($inputs);

        return $page->toResource(PageResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return $page->toResource(PageResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $inputs = $request->all();
        $page->update($inputs);

        return $page->toResource(PageResource::class);
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
