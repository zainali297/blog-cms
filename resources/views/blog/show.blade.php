<x-blog-layout :title="$post->title">
    <article class="bg-white shadow sm:rounded-lg p-8">
        @if ($post->image_url)
    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full max-h-96 object-cover rounded mb-6">
@endif
        <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
        <p class="text-sm text-gray-500 mt-2">
    By {{ $post->user->name }} &middot; {{ $post->published_at?->format('d M Y') }}
    @if ($post->category)
        &middot; <a href="{{ route('blog.category', $post->category) }}" class="text-indigo-600 hover:underline">{{ $post->category->name }}</a>
    @endif
        </p>
        
        <div class="mt-6 text-gray-800 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>
    </article>

    <a href="{{ route('home') }}" class="inline-block mt-6 text-indigo-600 hover:underline">
        &larr; Back to all posts
    </a>
</x-blog-layout>