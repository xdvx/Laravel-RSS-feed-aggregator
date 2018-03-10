<?php

namespace Tests\Unit;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Services\CategoriesManagerService;
use Tests\TestCase;
use App\Services\FeedsManagerService;
use App\Http\Requests\FeedStoreRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoriesManagerServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var CategoriesManagerService
     */
    protected $categoriesManagerService;

    public function setUp()
    {
        parent::setUp();

        $this->categoriesManagerService = app('App\Services\CategoriesManagerService');
    }

    /** @test */
    public function create()
    {

        $categoryData = array_only(factory(Category::class)->raw(), ['name']);
        $request = new CategoryStoreRequest([], [], $categoryData);

        $this->categoriesManagerService->create($request);

        $this->assertDatabaseHas('categories', $categoryData);
    }

    /** @test */
    public function remove()
    {
        $category = factory(Category::class)->create();
        $this->categoriesManagerService->remove($category);

        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    /** @test */
    public function update()
    {
        $category = factory(Category::class)->create();

        $newCategoryData = array_only(factory(Category::class)->raw(), ['name']);
        $request = new CategoryStoreRequest([], [], $newCategoryData);

        $this->categoriesManagerService->update($category, $request);

        $this->assertDatabaseHas('categories', $newCategoryData);
    }
}
