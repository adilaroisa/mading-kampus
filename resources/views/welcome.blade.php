<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CampusHub - TI UMY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; }
        .mading-img { aspect-ratio: 4/3; object-fit: cover; }
        /* Animasi halus saat hover */
        .float-card { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .float-card:hover { transform: translateY(-10px); }

        /* Profile dropdown animation */
        [x-cloak] { display: none !important; }
        .dropdown-enter { animation: dropIn 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body class="antialiased">
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b-4 border-gray-900 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter">Campus<span class="text-indigo-600">Hub</span></h1>

            <div class="flex items-center gap-4">
                @auth
                    {{-- Tombol Bookmark untuk user biasa --}}
                    @if(auth()->user()->role !== 'admin')
                        <a href="{{ route('bookmarks.index') }}"
                           class="font-black border-2 border-gray-900 px-5 py-2 rounded-full hover:bg-gray-100 transition flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            Bookmark
                        </a>
                    @else
                        <a href="{{ url('/admin/dashboard') }}"
                           class="font-black border-2 border-gray-900 px-5 py-2 rounded-full hover:bg-gray-100 transition flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                    @endif

                    {{-- Profile Dropdown --}}
                    <div x-data="{ open: false }" class="relative" @keydown.escape.window="open = false">

                        {{-- Trigger: Avatar + Nama --}}
                        <button @click="open = !open"
                                class="flex items-center gap-2.5 bg-gray-900 text-white pl-2 pr-4 py-2 rounded-full font-black hover:bg-indigo-600 transition focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            {{-- Avatar inisial --}}
                            <span class="w-8 h-8 rounded-full bg-teal-400 text-gray-900 flex items-center justify-center text-sm font-black uppercase flex-shrink-0">
                                {{ mb_substr(auth()->user()->name, 0, 1) }}
                            </span>
                            <span class="max-w-[120px] truncate text-sm">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="open"
                             x-cloak
                             @click.outside="open = false"
                             class="dropdown-enter absolute right-0 mt-3 w-64 bg-white border-4 border-gray-900 rounded-2xl shadow-[6px_6px_0_0_#111827] overflow-hidden z-50">

                            {{-- Header info user --}}
                            <div class="px-4 py-3 bg-indigo-50 border-b-2 border-gray-900">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-0.5">Masuk sebagai</p>
                                <p class="font-black text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition group">
                                    <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    Edit Profil
                                </a>

                                <a href="{{ route('profile.edit') }}#password"
                                   class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition group">
                                    <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </span>
                                    Ganti Password
                                </a>

                                @if(auth()->user()->role !== 'admin')
                                    <a href="{{ route('bookmarks.index') }}"
                                       class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition group">
                                        <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                            </svg>
                                        </span>
                                        Artikel Tersimpan
                                    </a>
                                @endif

                                <div class="border-t-2 border-gray-100 my-1"></div>

                                {{-- Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-black text-red-600 hover:bg-red-50 transition group">
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
                    <a href="{{ route('login') }}" class="font-black border-2 border-gray-900 px-6 py-2 rounded-full hover:bg-gray-900 hover:text-white transition">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-16">
            <h2 class="text-6xl font-extrabold text-gray-900 mb-6">Update Hari Ini.</h2>
            
            <div class="relative z-30 flex flex-wrap gap-3">
                <a href="/" class="px-6 py-3 rounded-2xl font-black {{ !request()->has('category') ? 'bg-indigo-600 text-white shadow-[4px_4px_0_0_#4f46e5]' : 'bg-white border-2 border-gray-900' }}">
                    # Semua
                </a>
                @foreach(\App\Models\Category::all() as $cat)
                    <a href="/?category={{ $cat->slug }}" class="px-6 py-3 rounded-2xl font-black transition-all transform hover:scale-105 shadow-[4px_4px_0_0_#111827] {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-white border-2 border-gray-900 hover:bg-teal-400' }}">
                        # {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles as $article)
                <div class="float-card bg-white p-3 rounded-[2rem] border-4 border-gray-900 shadow-[8px_8px_0_0_#111827]">
                    <div class="relative overflow-hidden rounded-[1.5rem] mb-4">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" class="mading-img w-full">
                        @else
                            <div class="mading-img w-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">No Image</div>
                        @endif
                        <span class="absolute top-4 left-4 px-3 py-1 bg-yellow-300 text-black font-black text-[10px] uppercase rounded-full">
                            {{ $article->category->name }}
                        </span>
                    </div>

                    <div class="px-2 pb-2">
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $article->title }}</h2>
                        <p class="text-gray-600 mb-6 font-medium">{{ Str::limit($article->content, 80) }}</p>
                        
                        <a href="{{ route('articles.show', $article->slug) }}" class="block w-full py-4 text-center rounded-2xl bg-teal-400 text-gray-900 font-black hover:bg-teal-300 transition border-b-4 border-teal-600 active:border-b-0 active:translate-y-1">
                            BACA LENGKAP
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-4xl font-black text-gray-300">Belum ada mading nih.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>