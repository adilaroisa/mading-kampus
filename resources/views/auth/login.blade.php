<x-guest-layout>
    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border-t-8 border-indigo-500">
        <div class="text-center mb-8 flex flex-col items-center">
            <x-application-logo class="mb-4" />
            <h2 class="text-3xl font-extrabold text-indigo-900 mt-2">Selamat Datang!</h2>
            <p class="text-gray-500 mt-2 text-sm">Masuk untuk menyimpan artikel mading favoritmu.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label for="email" class="block font-bold text-sm text-gray-700 mb-2">Email Kampus</label>
                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-400 focus-within:border-indigo-400 transition shadow-sm">
                    <span class="pl-4 pr-3 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </span>
                    <input id="email" class="block w-full border-none bg-transparent py-3 focus:ring-0 text-gray-700" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@student.umy.ac.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-6">
                <label for="password" class="block font-bold text-sm text-gray-700 mb-2">Kata Sandi</label>
                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-400 focus-within:border-indigo-400 transition shadow-sm">
                    <span class="pl-4 pr-3 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input id="password" class="block w-full border-none bg-transparent py-3 focus:ring-0 text-gray-700" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded text-indigo-500 focus:ring-indigo-500 border-gray-300 w-4 h-4 shadow-sm" name="remember">
                    <span class="ml-2 text-sm text-gray-600 font-medium">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-teal-600 hover:text-teal-800 transition" href="{{ route('password.request') }}">
                        {{ __('Lupa sandi?') }}
                    </a>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Masuk ke CampusHub
                </button>
            </div>
            
            <div class="mt-6 text-center">
                <a class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition" href="{{ route('register') }}">
                    Belum punya akun? Daftar di sini
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>