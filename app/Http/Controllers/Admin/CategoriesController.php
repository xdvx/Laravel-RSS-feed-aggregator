<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Services\CategoriesManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    private $categoriesManagerService;

    /**
     * CategoriesController constructor.
     */
    public function __construct(CategoriesManagerService $categoriesManagerService)
    {
        $this->categoriesManagerService = $categoriesManagerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $this->categoriesManagerService->create($request);

        return redirect()->route('categories.index')->with(['message' => 'Record created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.form', $category->only(['name']) + compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryStoreRequest  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        $this->categoriesManagerService->update($category, $request);

        return redirect()->route('categories.edit', $category)->with(['message' => 'Record updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->categoriesManagerService->remove($category);

        return redirect()->route('categories.index')->with(['message' => 'Record deleted']);
    }
}
