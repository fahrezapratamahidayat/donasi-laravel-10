<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                    Daftar Campaign Donasi
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Pilih campaign yang ingin Anda dukung dan mulai berbagi kebaikan
                </p>
            </div>

            <!-- Filter & Search Section -->
            <div class="mb-8 bg-white rounded-lg shadow p-6">
                <form action="{{ route('donasi.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Cari Campaign</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Cari berdasarkan judul...">
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                        <select name="sort"
                                id="sort"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="target_asc" {{ request('sort') == 'target_asc' ? 'selected' : '' }}>Target Terkecil</option>
                            <option value="target_desc" {{ request('sort') == 'target_desc' ? 'selected' : '' }}>Target Terbesar</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Campaign Grid -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($campaigns as $campaign)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg transition duration-300 hover:shadow-md">
                    <div class="relative pb-48">
                        <img class="absolute h-full w-full object-cover"
                             src="{{ asset('storage/' . $campaign->gambar) }}"
                             alt="{{ $campaign->judul_donasi }}"
                             onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                        <!-- Remaining Days Badge -->
                        @php
                            $remainingDays = \Carbon\Carbon::parse($campaign->tanggal_berakhir)->diffInDays(now());
                        @endphp
                        <div class="absolute top-0 right-0 m-2 px-2 py-1 bg-white bg-opacity-90 rounded text-sm">
                            {{ $remainingDays }} hari lagi
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <img class="h-8 w-8 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($campaign->user->name) }}"
                                 alt="{{ $campaign->user->name }}">
                            <span class="ml-2 text-sm text-gray-600">{{ $campaign->user->name }}</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $campaign->judul_donasi }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $campaign->deskripsi }}
                        </p>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-indigo-200">
                                    @php
                                        $percentage = ($campaign->donasi_terkumpul / $campaign->target_donasi) * 100;
                                    @endphp
                                    <div style="width: {{ $percentage }}%"
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="text-lg font-semibold text-gray-900">
                                    Rp {{ number_format($campaign->donasi_terkumpul) }}
                                    <span class="text-sm text-gray-600">terkumpul dari Rp {{ number_format($campaign->target_donasi) }}</span>
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ number_format($percentage, 1) }}% tercapai
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-users mr-1"></i>
                                {{ $campaign->donasiDetail->count() }} Donatur
                            </div>
                            <a href="{{ route('donasi.show', $campaign->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-500">
                        <i class="fas fa-folder-open text-4xl mb-4"></i>
                        <p class="text-lg">Belum ada campaign donasi yang tersedia</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $campaigns->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
