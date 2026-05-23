<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 to-purple-600 p-6 rounded-3xl shadow-lg mt-4">
            <h2 class="font-extrabold text-2xl text-white tracking-wide flex items-center gap-2">
                <svg class="w-7 h-7 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Panel Admin
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('admin.articles.index') }}" class="group flex items-center p-8 bg-white rounded-3xl shadow-sm border border-purple-100 hover:shadow-md hover:border-purple-300 transition-all duration-300">
                    <div class="bg-blue-50 p-4 rounded-2xl text-blue-600 mr-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Kelola Artikel</h4>
                        <p class="text-sm text-gray-500">Lihat, edit, atau hapus artikel.</p>
                    </div>
                </a>

                <a href="{{ route('admin.articles.create') }}" class="group flex items-center p-8 bg-white rounded-3xl shadow-sm border border-purple-100 hover:shadow-md hover:border-purple-300 transition-all duration-300">
                    <div class="bg-purple-50 p-4 rounded-2xl text-purple-600 mr-5 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Buat Baru</h4>
                        <p class="text-sm text-gray-500">Tambah pengumuman mading baru.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>