<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Dashboard Admin
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Overview statistik dan aktivitas campaign donasi
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Campaigns -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900 rounded-xl">
                                <i class="fas fa-hand-holding-heart text-2xl text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Campaign
                                    </dt>
                                    <dd class="mt-2">
                                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                            {{ $totalCampaigns }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Campaigns -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900 rounded-xl">
                                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Campaign Aktif
                                    </dt>
                                    <dd class="mt-2">
                                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                            {{ $activeCampaigns }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Campaigns -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-yellow-100 dark:bg-yellow-900 rounded-xl">
                                <i class="fas fa-clock text-2xl text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Menunggu Verifikasi
                                    </dt>
                                    <dd class="mt-2">
                                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                            {{ $pendingCampaigns }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Donations -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900 rounded-xl">
                                <i class="fas fa-money-bill-wave text-2xl text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Donasi
                                    </dt>
                                    <dd class="mt-2">
                                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
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
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Campaign Terbaru</h2>
                    <a href="{{ route('admin.donasi.index') }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentCampaigns as $campaign)
                        <li>
                            <a href="{{ route('admin.donasi.show', $campaign->id) }}"
                               class="block hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="px-6 py-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img class="h-12 w-12 rounded-xl object-cover"
                                                 src="{{ Storage::url($campaign->gambar) }}"
                                                 alt="{{ $campaign->judul_donasi }}">
                                            <div class="ml-4">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $campaign->judul_donasi }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    oleh {{ $campaign->user->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
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
    </div>
</x-admin-layout>
