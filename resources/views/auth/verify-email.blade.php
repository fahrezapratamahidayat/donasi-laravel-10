<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-sm">
            <!-- Header -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Verifikasi Email
                </h2>
                <div class="flex justify-center mb-4">
                    <i class="fas fa-envelope-open-text text-5xl text-indigo-600"></i>
                </div>
                <p class="text-sm text-gray-600">
                    Terima kasih telah mendaftar! Silakan verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan.
                    Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan email baru.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="rounded-xl bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                Link verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-4">
                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-paper-plane text-indigo-500 group-hover:text-indigo-400"></i>
                        </span>
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit"
                            class="text-sm font-medium text-gray-600 hover:text-indigo-500 transition duration-150">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
