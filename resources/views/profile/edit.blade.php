<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-3xl shadow-md mt-4">
            <h2 class="font-extrabold text-2xl text-white tracking-wide">
                {{ __('Pengaturan Profil') }}
            </h2>
            <p class="text-purple-100 text-sm mt-1">Kelola informasi identitas, keamanan kata sandi, dan privasi akun Anda.</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-purple-100/60 sticky top-6">
                        <div class="flex flex-col items-center text-center pb-6 border-b border-gray-100">
                            <div class="w-20 h-20 bg-gradient-to-tr from-blue-500 via-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h3 class="mt-4 font-bold text-lg text-gray-800">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="mt-6 space-y-1">
                            <a href="#profile-info" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-purple-50 text-purple-700 font-semibold text-sm transition-all duration-200">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Profil
                            </a>
                            <a href="#password-security" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-50 font-medium text-sm transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Keamanan Password
                            </a>
                            <a href="#danger-zone" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-red-600 hover:bg-red-50 font-medium text-sm transition-all duration-200">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Akun
                            </a>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    
                    <div id="profile-info" class="p-6 sm:p-8 bg-white shadow-sm border border-purple-100/60 rounded-3xl transition-all duration-300 hover:shadow-md">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div id="password-security" class="p-6 sm:p-8 bg-white shadow-sm border border-purple-100/60 rounded-3xl transition-all duration-300 hover:shadow-md">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div id="danger-zone" class="p-6 sm:p-8 bg-white shadow-sm border border-red-100 rounded-3xl transition-all duration-300 hover:shadow-md">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>