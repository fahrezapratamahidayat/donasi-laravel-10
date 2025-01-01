<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-2xl font-bold text-indigo-600">DonasiKu</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('donasi.my') }}"
                               class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2">Login</a>
                            <a href="{{ route('register') }}"
                               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block">Berbagi Kebaikan</span>
                                <span class="block text-indigo-600">Untuk Sesama</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Platform donasi online yang aman dan terpercaya. Mari bergabung dalam gerakan kebaikan untuk membantu sesama yang membutuhkan.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="{{ route('donasi.index') }}"
                                       class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                        Lihat Donasi
                                    </a>
                                </div>
                                @auth
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="{{ route('donasi.create') }}"
                                       class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                        Buat Donasi
                                    </a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Featured Campaigns -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Kampanye Donasi</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Campaign Yang Sedang Berjalan
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($campaigns as $campaign)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="relative pb-48">
                                <img class="absolute h-full w-full object-cover"
                                     src="{{ asset('storage/' . $campaign->gambar) }}"
                                     alt="{{ $campaign->judul_donasi }}"
                                     onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $campaign->judul_donasi }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                    {{ $campaign->deskripsi }}
                                </p>
                                <div class="mt-4">
                                    <div class="relative pt-1">
                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-indigo-200">
                                            <div style="width: {{ ($campaign->donasi_terkumpul / $campaign->target_donasi) * 100 }}%"
                                                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex justify-between text-sm text-gray-600">
                                        <span>Terkumpul: Rp {{ number_format($campaign->donasi_terkumpul) }}</span>
                                        <span>Target: Rp {{ number_format($campaign->target_donasi) }}</span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('donasi.show', $campaign->id) }}"
                                       class="block text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('donasi.index') }}"
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Lihat Semua Campaign
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <span class="text-gray-400">&copy; {{ date('Y') }} DonasiKu. All rights reserved.</span>
                </div>
            </div>
        </footer>
    </body>
</html>
