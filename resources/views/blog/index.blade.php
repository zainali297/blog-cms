<x-blog-layout :title="$currentCategory?->name ?? 'Home'">
    <h1 class="text-3xl font-bold mb-6">{{ $currentCategory?->name ?? 'Latest posts' }}</h1>

    <div class="flex flex-wrap gap-2 mb-8 text-sm">
        <a href="{{ route('home') }}"
           class="px-3 py-1 rounded-full {{ $currentCategory ? 'bg-white text-gray-700' : 'bg-indigo-600 text-white' }}">All</a>
        @foreach ($categories as $category)
            <a href="{{ route('blog.category', $category) }}"
               class="px-3 py-1 rounded-full {{ $currentCategory?->id === $category->id ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

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
                @if ($post->category)
                    &middot; <a href="{{ route('blog.category', $post->category) }}" class="text-indigo-600 hover:underline">{{ $post->category->name }}</a>
                @endif
            </p>
            <p class="mt-3 text-gray-700">{{ $post->excerpt ?: Str::limit($post->body, 160) }}</p>
            <a href="{{ route('blog.show', $post) }}" class="inline-block mt-3 text-indigo-600 hover:underline">
                Read more &rarr;
            </a>
        </article>
    @empty
        <p class="text-gray-600">No posts published here yet.</p>
    @endforelse

    <div class="mt-6">{{ $posts->links() }}</div>
</x-blog-layout>