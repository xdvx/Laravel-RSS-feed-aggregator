<?php

namespace App\Http\Controllers\Admin;

use App\Feed;
use App\Category;
use App\Http\Requests\FeedStoreRequest;
use App\Services\FeedsManagerService;
use App\Http\Controllers\Controller;

class FeedsController extends Controller
{

    private $feedsManagerService;

    /**
     * FeedsController constructor.
     *
     * @param FeedsManagerService $feedsManagerService
     */
    public function __construct(FeedsManagerService $feedsManagerService)
    {
        $this->feedsManagerService = $feedsManagerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeds = Feed::all();

        return view('admin.feeds.index', compact('feeds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $selected = collect([]);

        return view('admin.feeds.form', compact('categories', 'selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeedStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedStoreRequest $request)
    {

        $this->feedsManagerService->create($request);

        return redirect()->route('feeds.index')->with(['message' => 'Record created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Feed $feed
     * @return \Illuminate\Http\Response
     */
    public function edit(Feed $feed)
    {
        $categories = Category::all();
        $feed->load('categories');
        $selected = $feed->categories->pluck('id');

        return view('admin.feeds.form', $feed->only(['url', 'title']) + compact('feed', 'categories', 'selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeedStoreRequest $request
     * @param Feed $feed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FeedStoreRequest $request, Feed $feed)
    {
        $this->feedsManagerService->update($feed, $request);

        return redirect()->route('feeds.edit', $feed)->with(['message' => 'Record updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feed $feed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Feed $feed)
    {
        $this->feedsManagerService->remove($feed);

        return redirect()->route('feeds.index')->with(['message' => 'Record deleted']);
    }
}
