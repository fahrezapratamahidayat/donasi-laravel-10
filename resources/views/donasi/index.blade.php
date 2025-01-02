<x-app-layout>
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Daftar Campaign Donasi
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pilih campaign yang ingin Anda dukung dan mulai berbagi kebaikan
                </p>
            </div>

            <!-- Filter & Search Section -->
            <div class="mb-10 bg-white rounded-2xl shadow-sm p-8">
                <form action="{{ route('donasi.index') }}" method="GET" class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Cari Campaign</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               placeholder="Cari berdasarkan judul...">
                    </div>
                    <div class="space-y-2">
                        <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                        <select name="sort"
                                id="sort"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="target_asc" {{ request('sort') == 'target_asc' ? 'selected' : '' }}>Target Terkecil</option>
                            <option value="target_desc" {{ request('sort') == 'target_desc' ? 'selected' : '' }}>Target Terbesar</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition duration-150 font-medium shadow-sm">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Campaign Grid -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($campaigns as $campaign)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full">
                    <div class="relative pb-60">
                        <img class="absolute h-full w-full object-cover rounded-t-2xl"
                             src="{{ asset('storage/' . $campaign->gambar) }}"
                             alt="{{ $campaign->judul_donasi }}"
                             onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                        <!-- Remaining Days Badge -->
                        @php
                            $remainingDays = \Carbon\Carbon::parse($campaign->tanggal_berakhir)->diffInDays(now());
                        @endphp
                        <div class="absolute top-4 right-4 px-3 py-1.5 bg-white bg-opacity-95 rounded-lg text-sm font-medium shadow-sm">
                            {{ $remainingDays }} hari lagi
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center mb-4">
                            <img class="h-10 w-10 rounded-full border-2 border-white shadow-sm"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($campaign->user->name) }}&background=6366f1&color=fff"
                                 alt="{{ $campaign->user->name }}">
                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $campaign->user->name }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                            {{ $campaign->judul_donasi }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                            {{ $campaign->deskripsi }}
                        </p>

                        <!-- Progress Bar -->
                        <div class="space-y-4 mb-6 mt-auto">
                            <div class="relative">
                                <div class="overflow-hidden h-2.5 rounded-full bg-indigo-100">
                                    @php
                                        $percentage = ($campaign->donasi_terkumpul / $campaign->target_donasi) * 100;
                                    @endphp
                                    <div style="width: {{ $percentage }}%"
                                         class="h-full bg-indigo-600 rounded-full transition-all duration-300">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 mb-1">
                                    Rp {{ number_format($campaign->donasi_terkumpul) }}
                                    <span class="text-sm font-normal text-gray-600">terkumpul dari Rp {{ number_format($campaign->target_donasi) }}</span>
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ number_format($percentage, 1) }}% tercapai
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-users mr-1.5"></i>
                                {{ $campaign->donasiDetail->count() }} Donatur
                            </div>
                            <a href="{{ route('donasi.show', $campaign->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition duration-150 shadow-sm">
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-16">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-folder-open text-5xl mb-4"></i>
                        <p class="text-lg">Belum ada campaign donasi yang tersedia</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $campaigns->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
