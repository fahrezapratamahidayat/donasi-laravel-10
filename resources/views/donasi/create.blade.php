<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Buat Campaign Donasi Baru
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Isi form berikut untuk membuat campaign donasi baru
                    </p>
                </div>

                <!-- Form -->
                <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf

                    <!-- Judul Donasi -->
                    <div class="space-y-2">
                        <label for="judul_donasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Judul Campaign
                        </label>
                        <input type="text"
                               name="judul_donasi"
                               id="judul_donasi"
                               value="{{ old('judul_donasi') }}"
                               class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition duration-150"
                               placeholder="Contoh: Bantu Pembangunan Masjid">
                        @error('judul_donasi')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Deskripsi Campaign
                        </label>
                        <textarea name="deskripsi"
                                  id="deskripsi"
                                  rows="5"
                                  class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition duration-150"
                                  placeholder="Jelaskan detail campaign donasi Anda secara lengkap...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Target Donasi -->
                    <div class="space-y-2">
                        <label for="target_donasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Target Donasi
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                            </div>
                            <input type="number"
                                   name="target_donasi"
                                   id="target_donasi"
                                   value="{{ old('target_donasi') }}"
                                   min="10000"
                                   class="block w-full pl-12 pr-4 py-3 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition duration-150"
                                   placeholder="0">
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Minimal Rp 10.000</p>
                        @error('target_donasi')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                        <!-- Tanggal Mulai -->
                        <div class="space-y-2">
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Mulai
                            </label>
                            <input type="date"
                                   name="tanggal_mulai"
                                   id="tanggal_mulai"
                                   value="{{ old('tanggal_mulai') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition duration-150">
                            @error('tanggal_mulai')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Berakhir -->
                        <div class="space-y-2">
                            <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Berakhir
                            </label>
                            <input type="date"
                                   name="tanggal_berakhir"
                                   id="tanggal_berakhir"
                                   value="{{ old('tanggal_berakhir') }}"
                                   class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition duration-150">
                            @error('tanggal_berakhir')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Gambar -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Gambar Campaign
                        </label>
                        <div class="mt-1 flex justify-center px-6 py-8 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl">
                            <div class="space-y-2 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-image text-gray-400 text-4xl mb-3"></i>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="gambar" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload gambar</span>
                                            <input id="gambar"
                                                   name="gambar"
                                                   type="file"
                                                   accept="image/*"
                                                   class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        PNG, JPG, JPEG up to 2MB
                                    </p>
                                </div>
                            </div>
                        </div>
                        @error('gambar')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('donasi.my') }}"
                           class="px-6 py-3 border border-gray-300 dark:border-gray-700 rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-indigo-600 text-sm font-medium text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Buat Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview gambar yang diupload
        const gambarInput = document.getElementById('gambar');
        const previewContainer = document.querySelector('.flex.flex-col.items-center');

        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const existingPreview = previewContainer.querySelector('img');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('mt-4', 'h-40', 'w-auto', 'rounded-lg', 'object-cover');
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-app-layout>
