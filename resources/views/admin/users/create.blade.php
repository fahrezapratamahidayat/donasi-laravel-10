<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Tambah User Baru
                    </h2>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="grid gap-6 mb-6">
                        <div>
                            <x-input-label for="name" value="Nama" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" type="password" name="password" required
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                                class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
