<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-sm">
            <!-- Header -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Lupa Password?
                </h2>
                <p class="text-sm text-gray-600">
                    Masukkan email Anda untuk menerima link reset password
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                               placeholder="nama@email.com"
                               required
                               autofocus>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-paper-plane text-indigo-500 group-hover:text-indigo-400"></i>
                        </span>
                        Kirim Link Reset Password
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center text-sm">
                    <a href="{{ route('login') }}"
                       class="font-medium text-indigo-600 hover:text-indigo-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke halaman login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
