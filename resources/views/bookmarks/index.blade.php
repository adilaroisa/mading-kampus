<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Daftar Bookmark Mading
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($bookmarks as $article)
                            <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition flex flex-col">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-1 rounded font-semibold uppercase tracking-wide">
                                        {{ $article->category->name ?? 'Umum' }}
                                    </span>
                                    <form method="POST" action="{{ route('articles.bookmark', $article->id) }}">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-800 transition" title="Hapus dari Bookmark">
                                            <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-indigo-600 transition">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 flex-grow">{{ Str::limit($article->content, 80) }}</p>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-10 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Kamu belum menyimpan artikel mading apapun.
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-6">
                        {{ $bookmarks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>