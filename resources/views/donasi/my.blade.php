<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Campaign Saya
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Kelola campaign donasi yang Anda buat
                    </p>
                </div>
                <a href="{{ route('donasi.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> Buat Campaign
                </a>
            </div>

            <!-- Campaign List -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                @if($donasi->isEmpty())
                    <div class="p-8 text-center">
                        <i class="fas fa-folder-open text-4xl text-gray-400 dark:text-gray-600 mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">Anda belum memiliki campaign donasi</p>
                        <a href="{{ route('donasi.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            Buat Campaign Sekarang
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Campaign
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Target & Terkumpul
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Periode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Donatur
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($donasi as $campaign)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                         src="{{ Storage::url($campaign->gambar) }}"
                                                         alt="{{ $campaign->judul_donasi }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $campaign->judul_donasi }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        Dibuat {{ $campaign->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($campaign->donasi_terkumpul) }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                dari target Rp {{ number_format($campaign->target_donasi) }}
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="mt-1 w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                @php
                                                    $percentage = ($campaign->donasi_terkumpul / $campaign->target_donasi) * 100;
                                                @endphp
                                                <div class="bg-indigo-600 h-2.5 rounded-full"
                                                     style="width: {{ $percentage }}%">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' :
                                                   ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                            @if(!$campaign->is_verified)
                                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">
                                                    (Menunggu Verifikasi)
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($campaign->tanggal_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($campaign->tanggal_berakhir)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $campaign->donasiDetail->count() }} donatur
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
