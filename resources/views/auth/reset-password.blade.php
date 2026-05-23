<x-guest-layout>
    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border-t-8 border-indigo-500 mx-6">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-900">Buat Sandi Baru</h2>
            <p class="text-gray-500 mt-2 text-sm">Silakan isi form di bawah untuk membuat sandi baru.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-5">
                <label for="email" class="block font-bold text-sm text-gray-700 mb-2">Email Kampus</label>
                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-400 focus-within:border-indigo-400 transition shadow-sm">
                    <span class="pl-4 pr-3 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </span>
                    <input id="email" class="block w-full border-none bg-transparent py-3 focus:ring-0 text-gray-700" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="nama@student.umy.ac.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block font-bold text-sm text-gray-700 mb-2">Sandi Baru</label>
                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-400 focus-within:border-indigo-400 transition shadow-sm">
                    <span class="pl-4 pr-3 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input id="password" class="block w-full border-none bg-transparent py-3 focus:ring-0 text-gray-700" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block font-bold text-sm text-gray-700 mb-2">Konfirmasi Sandi</label>
                <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-400 focus-within:border-indigo-400 transition shadow-sm">
                    <span class="pl-4 pr-3 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    <input id="password_confirmation" class="block w-full border-none bg-transparent py-3 focus:ring-0 text-gray-700" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Reset Sandi
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
