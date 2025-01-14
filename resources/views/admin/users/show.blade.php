<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Detail User: {{ $user->name }}
                    </h2>
                </div>

                <div class="grid gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($user->role) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Dibuat</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-xl font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
