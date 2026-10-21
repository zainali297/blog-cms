<x-blog-layout title="Home">
    <h1 class="text-3xl font-bold mb-8">Latest posts</h1>

    @forelse ($posts as $post)
        <article class="bg-white shadow sm:rounded-lg p-6 mb-6">
            @if ($post->image_url)
    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded mb-4">
@endif
            <h2 class="text-2xl font-semibold">
                <a href="{{ route('blog.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                By {{ $post->user->name }} &middot; {{ $post->published_at?->format('d M Y') }}
            </p>
            <p class="mt-3 text-gray-700">{{ $post->excerpt ?: Str::limit($post->body, 160) }}</p>
            <a href="{{ route('blog.show', $post) }}" class="inline-block mt-3 text-indigo-600 hover:underline">
                Read more &rarr;
            </a>
        </article>
    @empty
        <p class="text-gray-600">No posts published yet.</p>
    @endforelse

    <div class="mt-6">{{ $posts->links() }}</div>
</x-blog-layout>