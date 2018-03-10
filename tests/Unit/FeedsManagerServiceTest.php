<?php

namespace Tests\Unit;

use App\Feed;
use App\Category;
use Tests\TestCase;
use App\Services\FeedsManagerService;
use App\Http\Requests\FeedStoreRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FeedsManagerServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var FeedsManagerService
     */
    protected $feedsManagerService;

    public function setUp()
    {
        parent::setUp();

        $this->feedsManagerService = app('App\Services\FeedsManagerService');


    }

    /** @test */
    public function create()
    {

        $feedData = array_only(factory(Feed::class)->raw(), ['url', 'title']);
        $request = new FeedStoreRequest([], [], $feedData);

        $this->feedsManagerService->create($request);

        $this->assertDatabaseHas('feeds', $feedData);
    }

    /** @test */
    public function remove()
    {
        $feed = factory(Feed::class)->create();
        $this->feedsManagerService->remove($feed);

        $this->assertDatabaseMissing('feeds', $feed->toArray());
    }

    /** @test */
    public function update()
    {
        $feed = factory(Feed::class)->create();

        $newFeedData = array_only(factory(Feed::class)->raw(), ['url', 'title']);
        $request = new FeedStoreRequest([], [], $newFeedData);

        $this->feedsManagerService->update($feed, $request);

        $this->assertDatabaseHas('feeds', $newFeedData);
    }

    /** @test */
    public function updateCategories()
    {
        $feed = factory(Feed::class)->create();
        $categories = factory(Category::class, 10)->create();
        $categoryIds = $categories->pluck('id')->toArray();

        $this->feedsManagerService->updateCategories($feed, $categoryIds);

        $assignedIds = $feed->categories->pluck('id')->toArray();

        $this->assertCount(10, $assignedIds);
        $this->assertSame($categoryIds, $assignedIds);
    }
}
