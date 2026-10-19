@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <header class="bg-white shadow">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">{{ config('app.name') }}</a>
            <nav class="flex gap-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    <a href="{{ route('posts.manage') }}" class="hover:underline">My Posts</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Log in</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10">
        {{ $slot }}
    </main>

    <footer class="text-center text-sm text-gray-500 py-8">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </footer>
</body>
</html>