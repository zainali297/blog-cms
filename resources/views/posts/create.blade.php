<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">New Post</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.store') }}" class="space-y-6">
                    @include('posts._form')
                    <x-primary-button>Save Post</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>