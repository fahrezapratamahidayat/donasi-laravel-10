<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Styles -->
        <style>
            .bg-auth-pattern {
                background-color: #f8fafc;
                background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
                background-size: 20px 20px;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col bg-auth-pattern">
            <!-- Navbar -->
            {{-- <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-100 fixed w-full z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <a href="/" class="flex items-center">
                                <span class="text-2xl font-bold text-indigo-600">DonasiKu</span>
                            </a>
                        </div>
                        <div class="flex items-center space-x-4">
                            @if(Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                       class="text-sm text-gray-700 hover:text-indigo-600 transition duration-150">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="text-sm text-gray-700 hover:text-indigo-600 transition duration-150">
                                        Login
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                           class="text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl transition duration-150">
                                            Daftar
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </nav> --}}

            <!-- Main Content -->
            <main class="flex-grow flex items-center justify-center p-4">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-4 text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} DonasiKu. All rights reserved.</p>
            </footer>
        </div>

        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>
