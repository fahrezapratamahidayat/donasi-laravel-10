<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Campaign Saya
                    </h2>
                    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                        Kelola campaign donasi yang Anda buat
                    </p>
                </div>
                <a href="{{ route('donasi.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                    <i class="fas fa-plus mr-2"></i> Buat Campaign
                </a>
            </div>

            <!-- Campaign List -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                @if($donasi->isEmpty())
                    <div class="p-12 text-center">
                        <i class="fas fa-folder-open text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                            Anda belum memiliki campaign donasi
                        </p>
                        <a href="{{ route('donasi.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition duration-150">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Campaign Sekarang
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Campaign
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Target & Terkumpul
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Periode
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Donatur
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($donasi as $campaign)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 flex-shrink-0">
                                                    <img class="h-12 w-12 rounded-xl object-cover"
                                                         src="{{ Storage::url($campaign->gambar) }}"
                                                         alt="{{ $campaign->judul_donasi }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $campaign->judul_donasi }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        Dibuat {{ $campaign->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($campaign->donasi_terkumpul) }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                dari target Rp {{ number_format($campaign->target_donasi) }}
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                                @php
                                                    $percentage = ($campaign->donasi_terkumpul / $campaign->target_donasi) * 100;
                                                @endphp
                                                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                                                     style="width: {{ $percentage }}%">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' :
                                                   ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                            @if(!$campaign->is_verified)
                                                <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                                    (Menunggu Verifikasi)
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($campaign->tanggal_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($campaign->tanggal_berakhir)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $campaign->donasiDetail->count() }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                donatur
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $donasi->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
