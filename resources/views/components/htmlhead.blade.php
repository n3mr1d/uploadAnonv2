<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | {{ $title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="min-h-screen text-white bg-gray-900">
    <header class="flex justify-between items-center py-4 px-6 mb-3 w-full text-xl font-semibold bg-gray-800 rounded">

        <div class="flex">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <span class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600">
                            <svg class="w-3 h-3 text-blue-300 me-2.5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            {{ config('app.name') }}
                        </span>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="mx-1 w-3 h-3 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 9l4-4-4-4" />
                            </svg>
                            <span aria-current="page"
                                class="text-sm font-medium text-white hover:text-blue-600 ms-1 md:ms-2">
                                {{ $title }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2 items-center">
            @if (Auth::check())
                <a href="{{ route('dashboard') }}"
                    class="flex gap-1 items-center p-2 text-sm text-white bg-blue-600 rounded cursor-pointer">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('index') }}"
                    class="flex gap-1 items-center p-2 text-sm text-white bg-blue-600 rounded cursor-pointer">
                    <i class="fa fa-home"></i> Home
                </a>
                <!-- Logout form -->
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="flex gap-1 items-center p-2 text-sm text-white bg-red-600 rounded cursor-pointer">
                        <i class="fa fa-sign-out"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="flex gap-1 items-center p-2 text-sm text-white bg-blue-600 rounded cursor-pointer">
                    <i class="fa fa-user"></i> Admin
                </a>
            @endif
        </div>


    </header>
    <main class="px-6 mx-auto w-full">
        {{ $slot }}
        <x-footer />

    </main>
</body>

</html>
