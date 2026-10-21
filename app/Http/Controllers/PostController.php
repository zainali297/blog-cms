<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function manage()
    {
        $posts = auth()->user()->posts()->latest()->paginate(10);

        return view('posts.manage', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        unset($data['image'], $data['remove_image']);

        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $request->user()->posts()->create($data);

        return redirect()->route('posts.manage')->with('success', 'Post created.');
    }

    public function edit(Post $post)
    {
        $this->authorizeOwner($post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeOwner($post);

        $data = $this->validated($request);
        unset($data['image'], $data['remove_image']);

        if ($data['status'] === 'published') {
            $data['published_at'] = $post->published_at ?? now();
        } else {
            $data['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($post);
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteImage($post);
            $data['image_path'] = null;
        }

        $post->update($data);

        return redirect()->route('posts.manage')->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->authorizeOwner($post);

        $this->deleteImage($post);
        $post->delete();

        return redirect()->route('posts.manage')->with('success', 'Post deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'body'         => ['required', 'string'],
            'status'       => ['required', 'in:draft,published'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'post';
        $slug = $base;
        $i = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function deleteImage(Post $post): void
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
    }

    private function authorizeOwner(Post $post): void
    {
        abort_unless($post->user_id === auth()->id(), 403);
    }
}