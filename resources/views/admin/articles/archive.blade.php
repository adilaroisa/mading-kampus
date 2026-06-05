<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mt-4">
            <h2 class="font-extrabold text-2xl text-gray-800 tracking-wide flex items-center gap-2">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                Arsip Mading (Kedaluwarsa)
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 font-bold text-gray-600">Judul Artikel</th>
                            <th class="px-6 py-4 font-bold text-gray-600">Kategori</th>
                            <th class="px-6 py-4 font-bold text-gray-600">Tgl Kedaluwarsa</th>
                            <th class="px-6 py-4 font-bold text-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($articles as $article)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $article->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $article->category->name ?? 'Umum' }}</td>
                            <td class="px-6 py-4 text-sm text-red-500 font-bold">{{ \Carbon\Carbon::parse($article->expires_at)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus Permanen?', 'Artikel ini akan dihapus permanen dan tidak bisa dikembalikan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 font-bold">
                                Tidak ada arsip mading saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
