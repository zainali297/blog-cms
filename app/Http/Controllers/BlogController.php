<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with('user')
            ->latest('published_at')
            ->paginate(6);

        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $post->load('user');

        return view('blog.show', compact('post'));
    }
}