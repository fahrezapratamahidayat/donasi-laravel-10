<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
                <div class="px-6 py-8">
                    <!-- Campaign Info -->
                    <div class="flex items-center mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
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

                    <!-- Nominal Selection -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Pilih Nominal Donasi
                            </h3>

                            <!-- Preset Amounts -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <a href="{{ route('donasi.payment', ['id' => $donasi->id, 'amount' => 30000]) }}"
                                    class="flex items-center justify-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-indigo-500 dark:hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200 group">
                                    <div class="text-center">
                                        <span class="text-4xl mb-2 block transform group-hover:scale-110 transition-transform duration-200">🎁</span>
                                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            Rp 30.000
                                        </span>
                                    </div>
                                </a>

                                <a href="{{ route('donasi.payment', ['id' => $donasi->id, 'amount' => 50000]) }}"
                                    class="flex items-center justify-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-indigo-500 dark:hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200 group">
                                    <div class="text-center">
                                        <span class="text-4xl mb-2 block transform group-hover:scale-110 transition-transform duration-200">💝</span>
                                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            Rp 50.000
                                        </span>
                                    </div>
                                </a>

                                <a href="{{ route('donasi.payment', ['id' => $donasi->id, 'amount' => 100000]) }}"
                                    class="flex items-center justify-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-indigo-500 dark:hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200 group">
                                    <div class="text-center">
                                        <span class="text-4xl mb-2 block transform group-hover:scale-110 transition-transform duration-200">💖</span>
                                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            Rp 100.000
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Custom Amount Form -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <span class="text-4xl">💫</span>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Nominal Lainnya
                                </h3>
                            </div>

                            <div class="space-y-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-xl font-semibold text-gray-500 dark:text-gray-400">Rp</span>
                                    </div>
                                    <input type="text" id="customAmount"
                                        class="pl-16 block w-full text-2xl font-bold rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-right pr-4"
                                        placeholder="0" oninput="formatRupiah(this)" maxlength="11">
                                </div>

                                <p class="text-sm text-gray-500 dark:text-gray-400 text-right" id="nominalPreview">
                                    Rp 0
                                </p>

                                <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-3 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Min. donasi Rp 10.000 - Maks. Rp 999.999.999
                                    </p>
                                </div>

                                <div id="customAmountButton" class="opacity-50 pointer-events-none">
                                    <button onclick="submitCustomAmount()"
                                        class="w-full inline-flex justify-center items-center py-3 px-4 border border-transparent shadow-sm text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                        <span>Lanjut ke Pembayaran</span>
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('customAmount');
            const button = document.getElementById('customAmountButton');
            const preview = document.getElementById('nominalPreview');

            input.value = '0';

            input.addEventListener('input', function(e) {
                let value = this.value.replace(/[^\d]/g, '');
                let number = value ? parseInt(value) : 0;
                let formatted = new Intl.NumberFormat('id-ID').format(number);

                this.value = formatted;

                if (preview) {
                    preview.textContent = `Rp ${formatted}`;
                }

                if (number >= 10000) {
                    button.classList.remove('opacity-50', 'pointer-events-none');
                } else {
                    button.classList.add('opacity-50', 'pointer-events-none');
                }
            });

            input.addEventListener('focus', function() {
                if (this.value === '0') {
                    this.value = '';
                }
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.value = '0';
                    if (preview) preview.textContent = 'Rp 0';
                }
            });
        });

        function submitCustomAmount() {
            const input = document.getElementById('customAmount');
            const amount = input.value.replace(/\D/g, '');
            const numericAmount = parseInt(amount);

            if (numericAmount < 10000) {
                alert('Minimal donasi Rp 10.000');
                return;
            }

            if (numericAmount > 999999999) {
                alert('Maksimal donasi Rp 999.999.999');
                return;
            }

            window.location.href = `{{ route('donasi.payment', ['id' => $donasi->id]) }}?amount=${amount}`;
        }
    </script>
    @endpush
</x-app-layout>
