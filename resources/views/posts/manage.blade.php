<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Posts</h2>
            <a href="{{ route('posts.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
                <table class="w-full text-left text-gray-900 dark:text-gray-100">
                    <thead class="border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Created</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="p-4">{{ $post->title }}</td>
                                <td class="p-4">{{ ucfirst($post->status) }}</td>
                                <td class="p-4">{{ $post->created_at->format('d M Y') }}</td>
                                <td class="p-4 flex gap-4">
                                    @if ($post->status === 'published')
    <a href="{{ route('blog.show', $post) }}" class="text-gray-600 hover:underline">View</a>
@endif
                                    <a href="{{ route('posts.edit', $post) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                          onsubmit="return confirm('Delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4">No posts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $posts->links() }}</div>
        </div>
    </div>
</x-app-layout>