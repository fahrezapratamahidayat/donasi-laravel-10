<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Campaign Details -->
            <div class="bg-white shadow-sm rounded-3xl overflow-hidden">
                <!-- Campaign Image -->
                <div class="relative h-[400px]">
                    <img src="{{ asset('storage/' . $donasi->gambar) }}"
                         alt="{{ $donasi->judul_donasi }}"
                         class="w-full h-full object-cover"
                         onerror="this.src='{{ asset('images/default-campaign.jpg') }}'">
                    <!-- Overlay for remaining days -->
                    <div class="absolute top-6 right-6 px-4 py-2 bg-white bg-opacity-95 rounded-xl shadow-sm">
                        <span class="text-sm font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->diffInDays(now()) }} hari lagi
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Campaign Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full border-2 border-white shadow-sm"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($donasi->user->name) }}&background=6366f1&color=fff"
                                 alt="{{ $donasi->user->name }}">
                            <div class="ml-4">
                                <h1 class="text-2xl font-bold text-gray-900 mb-1">
                                    {{ $donasi->judul_donasi }}
                                </h1>
                                <p class="text-sm text-gray-600">
                                    Dibuat oleh <span class="font-medium">{{ $donasi->user->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    <div class="bg-gray-50 rounded-2xl p-8 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Terkumpul</p>
                                <p class="text-2xl font-bold text-gray-900 mb-1">
                                    Rp {{ number_format($donasi->donasi_terkumpul) }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    dari Rp {{ number_format($donasi->target_donasi) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Donatur</p>
                                <p class="text-2xl font-bold text-gray-900 mb-1">
                                    {{ $donasi->donasiDetail->count() }}
                                </p>
                                <p class="text-sm text-gray-600">orang</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Sisa Waktu</p>
                                <p class="text-2xl font-bold text-gray-900 mb-1">
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->diffInDays(now()) }}
                                </p>
                                <p class="text-sm text-gray-600">hari lagi</p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-8">
                            <div class="relative">
                                <div class="overflow-hidden h-3 rounded-full bg-indigo-100">
                                    @php
                                        $percentage = ($donasi->donasi_terkumpul / $donasi->target_donasi) * 100;
                                    @endphp
                                    <div style="width: {{ $percentage }}%"
                                         class="h-full bg-indigo-600 rounded-full transition-all duration-300">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-sm font-medium text-gray-600">
                                {{ number_format($percentage, 1) }}% tercapai
                            </p>
                        </div>
                    </div>

                    <!-- Campaign Description -->
                    <div class="mb-12">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Tentang Campaign Ini
                        </h3>
                        <div class="prose prose-indigo max-w-none">
                            {{ $donasi->deskripsi }}
                        </div>
                    </div>

                    <!-- Recent Donations -->
                    <div class="mb-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            Donatur
                            <span class="ml-3 text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                {{ $donasi->donasiDetail->count() }}
                            </span>
                        </h3>
                        <div class="space-y-4">
                            @forelse($donasi->donasiDetail->where('status_pembayaran', 'settlement') as $detail)
                                <div class="flex items-center space-x-4 bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition duration-150">
                                    <img class="h-12 w-12 rounded-full border-2 border-white shadow-sm"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($detail->nama_donatur) }}&background=6366f1&color=fff"
                                         alt="{{ $detail->nama_donatur }}">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $detail->nama_donatur }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Berdonasi Rp {{ number_format($detail->jumlah_donasi) }}
                                        </p>
                                        @if($detail->keterangan)
                                            <p class="mt-1 text-sm text-gray-500 italic">
                                                "{{ $detail->keterangan }}"
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $detail->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 bg-gray-50 rounded-xl">
                                    <i class="fas fa-heart text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">Belum ada donasi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Action Buttons -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg py-4 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-4 relative">
                <a href="{{ route('donasi.amount', $donasi->id) }}"
                   class="flex-1 inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 shadow-sm">
                    <i class="fas fa-heart mr-2"></i>
                    Donasi Sekarang
                </a>
                <button onclick="toggleSharePopover()"
                        class="w-40 inline-flex justify-center items-center px-6 py-3.5 border border-gray-200 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition duration-150 shadow-sm">
                    <i class="fas fa-share-alt mr-2"></i>
                    Bagikan
                </button>

                <!-- Share Popover -->
                <div id="sharePopover"
                     class="absolute bottom-full right-0 mb-2 w-40 bg-white rounded-xl shadow-lg transform transition-all duration-200 ease-in-out z-50 hidden">
                    <div class="p-2 space-y-1">
                        <button onclick="shareToWhatsApp()"
                                class="w-full inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition duration-150">
                            <i class="fab fa-whatsapp text-green-500 text-lg mr-3"></i>
                            WhatsApp
                        </button>
                        <button onclick="shareToInstagram()"
                                class="w-full inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition duration-150">
                            <i class="fab fa-instagram text-pink-500 text-lg mr-3"></i>
                            Instagram
                        </button>
                        <button onclick="shareToFacebook()"
                                class="w-full inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition duration-150">
                            <i class="fab fa-facebook text-blue-500 text-lg mr-3"></i>
                            Facebook
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Pastikan script dijalankan setelah DOM loaded
        document.addEventListener('DOMContentLoaded', function() {
            window.toggleSharePopover = function() {
                const popover = document.getElementById('sharePopover');
                popover.classList.toggle('hidden');
            }

            window.shareToWhatsApp = function() {
                const text = "{{ $donasi->judul_donasi }}";
                const url = window.location.href;
                const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text + '\n\n' + url)}`;
                window.open(whatsappUrl, '_blank');
            }

            window.shareToFacebook = function() {
                const url = window.location.href;
                const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                window.open(facebookUrl, '_blank');
            }

            window.shareToInstagram = function() {
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link telah disalin! Anda dapat membagikannya di Instagram.');
                });
            }

            // Close popover when clicking outside
            document.addEventListener('click', function(event) {
                const popover = document.getElementById('sharePopover');
                const shareButton = document.querySelector('button[onclick="toggleSharePopover()"]');

                if (popover && shareButton && !popover.contains(event.target) && !shareButton.contains(event.target)) {
                    popover.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
