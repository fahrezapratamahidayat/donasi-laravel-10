<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Campaign Details -->
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <!-- Campaign Image -->
                <div class="relative h-96">
                    <img src="{{ asset('storage/' . $donasi->gambar) }}"
                         alt="{{ $donasi->judul_donasi }}"
                         class="w-full h-full object-cover"
                         onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                    <!-- Overlay for remaining days -->
                    <div class="absolute top-4 right-4 px-4 py-2 bg-white bg-opacity-90 rounded-full">
                        <span class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->diffInDays(now()) }} hari lagi
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Campaign Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($donasi->user->name) }}"
                                 alt="{{ $donasi->user->name }}">
                            <div class="ml-4">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $donasi->judul_donasi }}
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Dibuat oleh {{ $donasi->user->name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Terkumpul</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($donasi->donasi_terkumpul) }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    dari Rp {{ number_format($donasi->target_donasi) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Donatur</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $donasi->donasiDetail->count() }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">orang</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Sisa Waktu</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->diffInDays(now()) }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">hari lagi</p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-3 text-xs flex rounded bg-gray-200 dark:bg-gray-600">
                                    @php
                                        $percentage = ($donasi->donasi_terkumpul / $donasi->target_donasi) * 100;
                                    @endphp
                                    <div style="width: {{ $percentage }}%"
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ number_format($percentage, 1) }}% tercapai
                            </p>
                        </div>
                    </div>

                    <!-- Donation Form -->
                    <div class="flex space-x-4 mb-6">
                        <a href="{{ route('donasi.amount', $donasi->id) }}"
                           class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            <i class="fas fa-heart mr-2"></i>
                            Donasi Sekarang
                        </a>
                        <button onclick="share()"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-share-alt mr-2"></i>
                            Bagikan
                        </button>
                    </div>

                    <!-- Campaign Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Tentang Campaign Ini
                        </h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {{ $donasi->deskripsi }}
                        </div>
                    </div>

                    <!-- Recent Donations -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Donatur ({{ $donasi->donasiDetail->count() }})
                        </h3>
                        <div class="space-y-4">
                            @forelse($donasi->donasiDetail->where('status_pembayaran', 'settlement') as $detail)
                                <div class="flex items-center space-x-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <img class="h-10 w-10 rounded-full"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($detail->nama_donatur) }}"
                                         alt="{{ $detail->nama_donatur }}">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $detail->nama_donatur }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Berdonasi Rp {{ number_format($detail->jumlah_donasi) }}
                                        </p>
                                        @if($detail->keterangan)
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                "{{ $detail->keterangan }}"
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $detail->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    Belum ada donasi
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
let selectedAmount = 0;

function selectAmount(amount) {
    selectedAmount = amount;
    document.querySelectorAll('.donation-amount-btn').forEach(btn => {
        btn.classList.remove('border-indigo-500', 'dark:border-indigo-400');
    });
    event.currentTarget.classList.add('border-indigo-500', 'dark:border-indigo-400');

    // Hide custom amount form
    document.getElementById('customAmountForm').classList.add('hidden');

    // Update hidden input and enable button
    document.getElementById('jumlah_donasi').value = amount;
    document.getElementById('payButton').disabled = false;
}

function toggleCustomAmount() {
    document.querySelectorAll('.donation-amount-btn').forEach(btn => {
        btn.classList.remove('border-indigo-500', 'dark:border-indigo-400');
    });
    event.currentTarget.classList.add('border-indigo-500', 'dark:border-indigo-400');

    const customForm = document.getElementById('customAmountForm');
    customForm.classList.remove('hidden');
    document.getElementById('payButton').disabled = true;

    // Listen to custom amount input
    document.getElementById('customAmount').addEventListener('input', function(e) {
        const amount = parseInt(e.target.value);
        if (amount >= 2000) {
            document.getElementById('jumlah_donasi').value = amount;
            document.getElementById('payButton').disabled = false;
        } else {
            document.getElementById('payButton').disabled = true;
        }
    });
}
</script>
@endpush
