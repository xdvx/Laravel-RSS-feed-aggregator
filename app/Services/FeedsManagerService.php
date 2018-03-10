<?php

namespace App\Services;

use App\Feed;
use App\Http\Requests\FeedStoreRequest;

class FeedsManagerService
{
    /**
     * Create feed record
     *
     * @param FeedStoreRequest $request
     */
    public function create(FeedStoreRequest $request)
    {
        $feed = Feed::create([
            'url' => $request->get('url'),
            'title' => $request->get('title')
        ]);

        $categories = $request->get('categories');
        $this->updateCategories($feed, $categories);

    }

    /**
     * Removes feed from Database
     *
     * @param Feed $feed
     */
    public function remove(Feed $feed)
    {
        if ($feed) {
            $feed->delete();
        }
    }

    /**
     * Update Feed
     *
     * @param Feed $feed
     * @param FeedStoreRequest $request
     */
    public function update(Feed $feed, FeedStoreRequest $request)
    {
        $feed->url = $request->get('url');
        $feed->title = $request->get('title');

        $feed->save();

        $categories = $request->get('categories');
        $this->updateCategories($feed, $categories);

    }

    /**
     * Updates group(s) for specific feed
     *
     * @param Feed $feed
     * @param array $groupIds
     */
    public function updateCategories(Feed $feed, $groupIds)
    {
        if ($feed && $groupIds) {
            $feed->categories()->sync($groupIds);
        }
    }
}