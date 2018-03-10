<?php

namespace App\Services;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;

class CategoriesManagerService
{
    /**
     * Create category record
     *
     * @param CategoryStoreRequest $request
     */
    public function create(CategoryStoreRequest $request)
    {
        Category::create([
            'name' => $request->get('name')
        ]);
    }

    /**
     * Removes category from Database
     *
     * @param Category $category
     */
    public function remove(Category $category)
    {
        if ($category) {
            $category->delete();
        }
    }

    /**
     * Update Category
     *
     * @param Category $category
     * @param CategoryStoreRequest $request
     */
    public function update(Category $category, CategoryStoreRequest $request)
    {
        $category->name = $request->get('name');
        $category->save();
    }
}