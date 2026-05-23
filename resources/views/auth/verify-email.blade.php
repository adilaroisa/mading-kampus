<x-guest-layout>
    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border-t-8 border-teal-400 mx-6">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-900">Verifikasi Email</h2>
            <p class="text-gray-500 mt-2 text-sm">Terima kasih telah mendaftar! Sebelum memulai, bisa kah kamu memverifikasi email dengan mengklik link yang kami kirimkan ke emailmu. Jika kamu tidak menerima email, kami dengan senang hati akan mengirimkannya lagi.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="font-medium text-sm text-green-800">
                    Link verifikasi baru telah dikirim ke email yang kamu berikan saat pendaftaran.
                </p>
            </div>
        @endif

        <div class="flex items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf

                <button type="submit" class="w-full flex justify-center py-3 px-4 border-2 border-gray-300 rounded-xl text-sm font-extrabold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
