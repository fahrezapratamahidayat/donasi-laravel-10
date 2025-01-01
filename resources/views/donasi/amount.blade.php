<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <!-- Campaign Info -->
                    <div class="flex items-center mb-6">
                        <img class="h-16 w-16 rounded-lg object-cover" src="{{ asset('storage/' . $donasi->gambar) }}"
                            alt="{{ $donasi->judul_donasi }}">
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $donasi->judul_donasi }}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                oleh {{ $donasi->user->name }}
                            </p>
                        </div>
                    </div>

                    <!-- Nominal Selection -->
                    <div class="space-y-6">
                        <!-- Preset Amounts -->
                        <div class="grid grid-cols-3 gap-4">
                            <a href="{{ route('donasi.payment', ['id' => $donasi->id, 'amount' => 30000]) }}"
                                class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors duration-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <span class="text-3xl">🎁</span>
                                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Rp
                                        30.000</span>
                                </div>
                            </a>

                            <a href="{{ route('donasi.payment', ['id' => $donasi->id, 'amount' => 50000]) }}"
                                class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors duration-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <span class="text-3xl">💝</span>
                                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Rp
                                        50.000</span>
                                </div>
                            </a>

                            <a href="{{ route('donasi.payment', ['id' => $donasi->id, 'amount' => 100000]) }}"
                                class="p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors duration-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <span class="text-3xl">💖</span>
                                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Rp
                                        100.000</span>
                                </div>
                            </a>
                        </div>

                        <!-- Custom Amount Form - Always Visible -->
                        <div
                            class="bg-white dark:bg-gray-700 rounded-lg border-2 border-gray-200 dark:border-gray-600 p-6">
                            <div class="flex items-center space-x-3 mb-4">
                                <span class="text-3xl">💫</span>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Nominal Lainnya
                                </h3>
                            </div>

                            <div class="relative mb-2">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-xl font-semibold text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="text" id="customAmount"
                                    class="pl-16 block w-full text-2xl font-bold rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-right pr-4"
                                    placeholder="0" oninput="formatRupiah(this)" maxlength="11">
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-right mb-2" id="nominalPreview">
                                Rp 0
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-4">
                                Min. donasi Rp 10.000 - Maks. Rp 999.999.999
                            </p>

                            <div id="customAmountButton" class="opacity-50 pointer-events-none">
                                <button onclick="submitCustomAmount()"
                                    class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Lanjut ke Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Pastikan DOM sudah siap
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('customAmount');
                const button = document.getElementById('customAmountButton');
                const preview = document.getElementById('nominalPreview');

                // Set initial value
                input.value = '0';

                // Input event handler
                input.addEventListener('input', function(e) {
                    let value = this.value.replace(/[^\d]/g, '');

                    // Convert to number
                    let number = value ? parseInt(value) : 0;

                    // Format to currency
                    let formatted = new Intl.NumberFormat('id-ID').format(number);

                    // Update input
                    this.value = formatted;

                    // Update preview
                    if (preview) {
                        preview.textContent = `Rp ${formatted}`;
                    }

                    // Toggle button state
                    if (number >= 10000) {
                        button.classList.remove('opacity-50', 'pointer-events-none');
                    } else {
                        button.classList.add('opacity-50', 'pointer-events-none');
                    }
                });

                // Focus handler
                input.addEventListener('focus', function() {
                    if (this.value === '0') {
                        this.value = '';
                    }
                });

                // Blur handler
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.value = '0';
                        if (preview) preview.textContent = 'Rp 0';
                    }
                });
            });

            // Submit handler
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
