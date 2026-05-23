<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
            <h2 class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 leading-tight">
                Artikel Tersimpan
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($bookmarks as $article)
                            <div class="border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow bg-white">
                                <div class="flex justify-between items-start p-4 bg-gradient-to-r from-indigo-50 to-purple-50">
                                    <span class="bg-indigo-600 text-white text-xs px-3 py-1.5 rounded-full font-bold uppercase tracking-wide">
                                        {{ $article->category->name ?? 'Umum' }}
                                    </span>
                                    <form method="POST" action="{{ route('articles.bookmark', $article->id) }}" onsubmit="return confirm('Hapus dari bookmark?')">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-red-600 transition" title="Hapus dari Bookmark">
                                            <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="p-4 flex flex-col h-full">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-indigo-600 transition line-clamp-2">
                                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-600 flex-grow line-clamp-2 mb-4">{{ Str::limit($article->content, 80) }}</p>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="inline-block text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold px-4 py-2 rounded-lg hover:shadow-lg hover:shadow-indigo-200 transition text-sm">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                <p class="text-lg font-bold text-gray-400">Belum ada artikel yang kamu simpan.</p>
                                <p class="text-sm text-gray-500 mt-2">Mulai simpan artikel menarik untuk dibaca kemudian! 📚</p>
                            </div>
                        @endforelse
                    </div>
                    @if($bookmarks->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $bookmarks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>