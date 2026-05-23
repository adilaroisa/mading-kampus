<x-guest-layout>
    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border-t-8 border-indigo-500 mx-6">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-900">Konfirmasi Sandi</h2>
            <p class="text-gray-500 mt-2 text-sm">Ini adalah area aman. Silakan konfirmasi sandi kamu sebelum melanjutkan.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block font-bold text-sm text-gray-700 mb-2">Sandi</label>
                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-400 focus-within:border-indigo-400 transition shadow-sm">
                    <span class="pl-4 pr-3 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input id="password" class="block w-full border-none bg-transparent py-3 focus:ring-0 text-gray-700" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
