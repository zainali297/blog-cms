<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'posts' => $this->publishedPosts()->paginate(6),
            'categories' => Category::orderBy('name')->get(),
            'currentCategory' => null,
        ]);
    }

    public function category(Category $category)
    {
        return view('blog.index', [
            'posts' => $this->publishedPosts()->where('category_id', $category->id)->paginate(6),
            'categories' => Category::orderBy('name')->get(),
            'currentCategory' => $category,
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $post->load(['user', 'category']);

        return view('blog.show', compact('post'));
    }

    private function publishedPosts()
    {
        return Post::published()
            ->with(['user', 'category'])
            ->latest('published_at');
    }
}