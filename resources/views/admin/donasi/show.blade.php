<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Status and Actions -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            Detail Campaign
                        </h2>
                        <div class="mt-2 flex items-center">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full mr-2
                                {{ $donasi->status === 'active' ? 'bg-green-100 text-green-800' :
                                   ($donasi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-red-100 text-red-800') }}">
                                Status: {{ ucfirst($donasi->status) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                {{ $donasi->is_verified ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                {{ $donasi->is_verified ? 'Terverifikasi' : 'Belum Diverifikasi' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        @if(!$donasi->is_verified)
                            <form action="{{ route('admin.donasi.verify', $donasi->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-150">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Verifikasi Campaign
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.donasi.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:border-gray-900 dark:focus:border-gray-100 focus:ring ring-gray-300 disabled:opacity-25 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaign Details -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full"
                             src="https://ui-avatars.com/api/?name={{ urlencode($donasi->user->name) }}"
                             alt="{{ $donasi->user->name }}">
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $donasi->judul_donasi }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Dibuat oleh {{ $donasi->user->name }}
                            </p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                        {{ $donasi->status === 'active' ? 'bg-green-100 text-green-800' :
                           ($donasi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           'bg-red-100 text-red-800') }}">
                        {{ ucfirst($donasi->status) }}
                        @if(!$donasi->is_verified)
                            <span class="ml-1 text-xs">(Belum Diverifikasi)</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <!-- Campaign Image -->
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $donasi->gambar) }}"
                         alt="{{ $donasi->judul_donasi }}"
                         class="w-full h-64 object-cover rounded-lg"
                         onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                </div>

                <!-- Campaign Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Informasi Campaign
                        </h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Target Donasi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($donasi->target_donasi) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terkumpul</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($donasi->donasi_terkumpul) }}
                                    ({{ number_format(($donasi->donasi_terkumpul / $donasi->target_donasi) * 100, 1) }}%)
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode Campaign</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->format('d M Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Donatur</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $donasi->donasiDetail->count() }} donatur
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Deskripsi Campaign
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">
                            {{ $donasi->deskripsi }}
                        </p>
                    </div>
                </div>

                <!-- Donation List -->
                <div class="mt-8">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Riwayat Donasi
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Donatur
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($donasi->donasiDetail as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $detail->nama_donatur }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $detail->user->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($detail->jumlah_donasi) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $detail->status_pembayaran === 'settlement' ? 'bg-green-100 text-green-800' :
                                                   ($detail->status_pembayaran === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($detail->status_pembayaran) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $detail->created_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada donasi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <!-- Success Alert -->
        <div class="fixed bottom-4 right-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
</x-admin-layout>
