<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Post;
use Cookie;


class MainController extends Controller
{

    /**
     * @return array
     */
    private function categoriesFromCookie()
    {
        $filter = request()->cookie('categories');

        if ($filter) {
            return explode(',', $filter);
        }

        return [];

    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getPosts()
    {
        $categories = request('categories');

        if (! $categories) {
          $this->categoriesFromCookie();
        }

        $queryBuilder = Post::with('feed', 'feed.categories');

        if (! empty($categories)) {
            $queryBuilder->whereHas('feed.categories', function ($query) use ($categories) {
                $query->whereIn('id', $categories);
            });
        }

        return  $queryBuilder->orderBy('id', 'DESC')
            ->paginate(50);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->getPosts();
        $categories = Category::all();
        $selected = collect($this->categoriesFromCookie());

        return view('main', compact('posts', 'categories', 'selected'));
    }

    /**
     * @return $this|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function ajaxPosts()
    {
        if (request('categories')) {
            $cookie = Cookie::forever('categories', join(",", request('categories')));
            return response()->json($this->getPosts())
                ->withCookie($cookie);
        }

         return $this->getPosts();
    }
}
