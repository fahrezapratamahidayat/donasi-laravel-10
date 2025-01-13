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
            <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-2 gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Pengguna</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="Cari berdasarkan judul...">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition duration-150 font-medium shadow-sm">
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
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nama</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Email</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Role</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Dibuat Tanggal</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Diupdate Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{ $user->created_at->format('d F Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{ $user->updated_at->format('d F Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                </a>
                                <a href="{{ route('admin.users.destroy', $user) }}"
                                    class="text-red-600 hover:text-red-900">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
