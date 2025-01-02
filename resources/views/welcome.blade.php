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
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-2xl font-bold text-indigo-600 tracking-tight">DonasiKu</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('donasi.my') }}"
                               class="text-gray-700 hover:text-indigo-600 font-medium transition duration-150">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-gray-700 hover:text-indigo-600 font-medium px-4 py-2 transition duration-150">Login</a>
                            <a href="{{ route('register') }}"
                               class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 font-medium transition duration-150 shadow-sm">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-16 mx-auto max-w-7xl px-6 sm:mt-20 md:mt-24 lg:px-8">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-5xl tracking-tight font-extrabold text-gray-900 sm:text-6xl md:text-7xl leading-tight">
                                <span class="block mb-2">Berbagi Kebaikan</span>
                                <span class="block text-indigo-600">Untuk Sesama</span>
                            </h1>
                            <p class="mt-6 text-lg text-gray-600 sm:text-xl max-w-2xl leading-relaxed">
                                Platform donasi online yang aman dan terpercaya. Mari bergabung dalam gerakan kebaikan untuk membantu sesama yang membutuhkan.
                            </p>
                            <div class="mt-8 sm:mt-10 space-x-4">
                                <a href="{{ route('donasi.index') }}"
                                   class="inline-flex items-center px-8 py-3.5 rounded-xl text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 shadow-md">
                                    Lihat Donasi
                                </a>
                                @auth
                                <a href="{{ route('donasi.create') }}"
                                   class="inline-flex items-center px-8 py-3.5 rounded-xl text-base font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition duration-150">
                                    Buat Donasi
                                </a>
                                @endauth
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Featured Campaigns -->
        <div class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-sm text-indigo-600 font-semibold tracking-wide uppercase mb-3">Kampanye Donasi</h2>
                    <p class="text-4xl font-bold text-gray-900 tracking-tight">
                        Campaign Yang Sedang Berjalan
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($campaigns as $campaign)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                        <div class="relative pb-60">
                            <img class="absolute h-full w-full object-cover rounded-t-2xl"
                                 src="{{ asset('storage/' . $campaign->gambar) }}"
                                 alt="{{ $campaign->judul_donasi }}"
                                 onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem]">
                                {{ $campaign->judul_donasi }}
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-6">
                                {{ $campaign->deskripsi }}
                            </p>
                            <div class="space-y-4">
                                <div class="relative">
                                    <div class="overflow-hidden h-2.5 rounded-full bg-indigo-100">
                                        <div style="width: {{ ($campaign->donasi_terkumpul / $campaign->target_donasi) * 100 }}%"
                                             class="h-full bg-indigo-600 rounded-full">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Terkumpul: Rp {{ number_format($campaign->donasi_terkumpul) }}</span>
                                    <span>Target: Rp {{ number_format($campaign->target_donasi) }}</span>
                                </div>
                                <a href="{{ route('donasi.show', $campaign->id) }}"
                                   class="block text-center px-6 py-3 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-16 text-center">
                    <a href="{{ route('donasi.index') }}"
                       class="inline-flex items-center px-8 py-3.5 rounded-xl text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 shadow-md">
                        Lihat Semua Campaign
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto py-12 px-6 flex justify-center">
                <span class="text-gray-500">&copy; {{ date('Y') }} DonasiKu. All rights reserved.</span>
            </div>
        </footer>
    </body>
</html>
