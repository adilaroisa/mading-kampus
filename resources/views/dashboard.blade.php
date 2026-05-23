<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-indigo-500 to-purple-500 p-6 rounded-2xl shadow-lg mt-4 border-b-4 border-teal-400">
            <h2 class="font-extrabold text-2xl text-white tracking-wide flex items-center gap-2">
                🚀 {{ __('Admin Space') }}
            </h2>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-teal-400 mb-2">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-gray-500 font-medium">Saatnya mengatur mading hari ini. Apa informasi baru untuk prodi?</p>
                    
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('admin.articles.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold px-6 py-3 rounded-full shadow-md transition duration-300 transform hover:-translate-y-1">📝 Kelola Pengumuman</a>
                        <a href="{{ route('admin.articles.create') }}" class="bg-teal-100 text-teal-800 hover:bg-teal-200 font-bold px-6 py-3 rounded-full shadow-sm transition duration-300 transform hover:-translate-y-1 border border-teal-300">✨ Buat Mading Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>