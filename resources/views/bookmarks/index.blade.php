<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DiMadingin - Bookmark</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; }
        .mading-img { aspect-ratio: 4/3; object-fit: cover; }
        .float-card { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .float-card:hover { transform: translateY(-10px); }
        [x-cloak] { display: none !important; }
        .dropdown-enter { animation: dropIn 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body class="antialiased">
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter">Di<span class="text-indigo-600">Madingin</span></h1>

            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->role !== 'admin')
                        <a href="{{ request()->routeIs('bookmarks.index') ? route('home') : route('bookmarks.index') }}"
                           class="font-bold border-2 border-indigo-600 text-indigo-600 px-5 py-2 rounded-full bg-indigo-50 hover:bg-indigo-100 transition flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            {{ request()->routeIs('bookmarks.index') ? 'Dashboard' : 'Bookmark' }}
                        </a>
                    @else
                        <a href="{{ url('/admin/dashboard') }}"
                           class="font-bold border-2 border-indigo-600 text-indigo-600 px-5 py-2 rounded-full hover:bg-indigo-50 transition flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                    @endif

                    <div x-data="{ open: false }" class="relative" @keydown.escape.window="open = false">
                        <button @click="open = !open"
                                class="flex items-center gap-2.5 bg-indigo-600 text-white pl-2 pr-4 py-2 rounded-full font-bold hover:bg-indigo-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            <span class="w-8 h-8 rounded-full bg-purple-400 text-white flex items-center justify-center text-sm font-bold uppercase flex-shrink-0">
                                {{ mb_substr(auth()->user()->name, 0, 1) }}
                            </span>
                            <span class="max-w-[120px] truncate text-sm">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open"
                             x-cloak
                             @click.outside="open = false"
                             class="dropdown-enter absolute right-0 mt-3 w-64 bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden z-50">
                            <div class="px-4 py-3 bg-indigo-50 border-b border-gray-100">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-0.5">Masuk sebagai</p>
                                <p class="font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition group">
                                    <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    Profile
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 transition group">
                                        <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-red-100 flex items-center justify-center transition flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                        </span>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="font-bold border-2 border-indigo-600 text-indigo-600 px-6 py-2 rounded-full hover:bg-indigo-600 hover:text-white transition">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-10">
            <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-4">Artikel Tersimpan</h2>
            <p class="text-gray-500 text-lg">Kumpulkan kembali artikel favoritmu dengan tampilan yang serupa seperti dashboard.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bookmarks as $article)
                <div class="relative group">
                    <a href="{{ route('articles.show', $article->slug) }}" class="flex flex-col h-full float-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden border border-gray-100">
                        <div class="relative overflow-hidden bg-gray-100">
                            @if($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" class="mading-img w-full group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="mading-img w-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-gray-400 font-bold group-hover:scale-105 transition-transform duration-500">No Image</div>
                            @endif
                            <span class="absolute top-4 left-4 px-3 py-1.5 bg-indigo-600 text-white font-bold text-xs uppercase rounded-full shadow-md z-10">
                                {{ $article->category->name ?? 'Umum' }}
                            </span>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h2 class="text-lg font-extrabold text-gray-900 mb-3 leading-tight line-clamp-2 group-hover:text-indigo-600 transition">{{ $article->title }}</h2>
                            <p class="text-gray-600 mb-4 font-medium text-sm flex-grow line-clamp-2">{{ Str::limit($article->content, 80) }}</p>
                            
                            <div class="mt-4 block w-full py-3 text-center rounded-xl bg-indigo-50 text-indigo-700 font-bold group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 text-sm">
                                Baca Selengkapnya
                            </div>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('articles.bookmark', $article->id) }}" onsubmit="return confirm('Hapus dari bookmark?')" class="absolute top-4 right-4 z-20">
                        @csrf
                        <button type="submit" class="p-2 bg-white rounded-full text-indigo-600 hover:text-red-600 hover:bg-red-50 shadow-md transition-colors" title="Hapus dari Bookmark">
                            <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl shadow-lg border border-gray-100">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <p class="text-4xl font-black text-gray-300">Belum ada artikel yang kamu simpan.</p>
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
</body>
</html>
