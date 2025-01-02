<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Campaign Info -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl mb-8">
                <div class="p-6">
                    <div class="flex items-center">
                        <img class="h-20 w-20 rounded-xl object-cover shadow-sm"
                             src="{{ asset('storage/' . $donasi->gambar) }}"
                             alt="{{ $donasi->judul_donasi }}"
                             onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                        <div class="ml-5">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                                {{ $donasi->judul_donasi }}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                oleh {{ $donasi->user->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-8">
                    <form id="paymentForm" action="{{ route('donasi.donate', $donasi->id) }}" method="POST">
                        @csrf
                        <!-- Nominal Donasi -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <i class="fas fa-money-bill-wave text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                Total Donasi
                            </h3>
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-6">
                                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($amount) }}
                                </div>
                            </div>
                            <input type="hidden" name="jumlah_donasi" value="{{ $amount }}">
                        </div>

                        <!-- Donatur Info -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <i class="fas fa-user text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                Informasi Donatur
                            </h3>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Lengkap
                                    </label>
                                    <input type="text"
                                           name="nama_donatur"
                                           value="{{ auth()->user()->name }}"
                                           class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email
                                    </label>
                                    <input type="email"
                                           value="{{ auth()->user()->email }}"
                                           class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base bg-gray-50 dark:bg-gray-700"
                                           readonly>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                               name="is_anonymous"
                                               class="rounded-lg border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                            Sembunyikan nama saya (donasi sebagai anonim)
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Doa/Dukungan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <i class="fas fa-pray text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                Doa dan Dukungan
                            </h3>
                            <textarea name="keterangan"
                                      rows="3"
                                      class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base"
                                      placeholder="Tulis doa atau dukungan Anda di sini..."></textarea>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Maksimal 280 karakter
                            </p>
                        </div>

                        <!-- Payment Button -->
                        <button type="submit"
                                class="w-full inline-flex justify-center items-center px-6 py-4 border border-transparent shadow-sm text-lg font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <i class="fas fa-lock mr-2"></i>
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <div class="flex items-center justify-center text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-shield-alt text-indigo-600 dark:text-indigo-400 mr-2"></i>
                    <p>Pembayaran aman dan terenkripsi</p>
                </div>
                <p class="mt-2 text-center text-sm text-gray-500 dark:text-gray-400">
                    Donasi yang Anda berikan akan digunakan sesuai dengan program yang telah ditentukan.
                </p>
            </div>
        </div>
    </div>

    @if(session('snap_token'))
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            window.snap.pay('{{ session('snap_token') }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route('donasi.show', $donasi->id) }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route('donasi.show', $donasi->id) }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    window.location.href = '{{ route('donasi.show', $donasi->id) }}';
                },
                onClose: function() {
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        </script>
    @endif
</x-app-layout>
