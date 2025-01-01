<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Campaigns -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-hand-holding-heart text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total Campaign
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $totalCampaigns }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Campaigns -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Campaign Aktif
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $activeCampaigns }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Campaigns -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-2xl text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Menunggu Verifikasi
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $pendingCampaigns }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Donations -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total Donasi
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        Rp {{ number_format($totalDonations) }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Campaigns -->
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Campaign Terbaru</h2>
                <a href="{{ route('admin.donasi.index') }}"
                   class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                    Lihat Semua
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentCampaigns as $campaign)
                    <li>
                        <a href="{{ route('admin.donasi.show', $campaign->id) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full"
                                             src="{{ Storage::url($campaign->gambar) }}"
                                             alt="{{ $campaign->judul_donasi }}">
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $campaign->judul_donasi }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                oleh {{ $campaign->user->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' :
                                               ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                               'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout>
