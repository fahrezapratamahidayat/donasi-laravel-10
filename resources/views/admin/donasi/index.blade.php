<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Kelola Campaign
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Daftar semua campaign donasi
                </p>
            </div>
        </div>

        <!-- Filter -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <form action="{{ route('admin.donasi.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label for="verified" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verifikasi</label>
                    <select name="verified" id="verified" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <option value="">Semua</option>
                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Belum Diverifikasi</option>
                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Sudah Diverifikasi</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Campaign List -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terkumpul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($donasi as $campaign)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                         src="{{ asset('storage/' . $campaign->gambar) }}"
                                         alt="{{ $campaign->judul_donasi }}"
                                         onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $campaign->judul_donasi }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        oleh {{ $campaign->user->name }}
                                    </div>
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
                                <span class="ml-1 text-xs text-gray-500">(Belum Diverifikasi)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Rp {{ number_format($campaign->target_donasi) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Rp {{ number_format($campaign->donasi_terkumpul) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.donasi.show', $campaign->id) }}"
                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Detail
                            </a>
                            @if(!$campaign->is_verified)
                                <form action="{{ route('admin.donasi.verify', $campaign->id) }}"
                                      method="POST"
                                      class="inline ml-3">
                                    @csrf
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        Verifikasi
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $donasi->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
