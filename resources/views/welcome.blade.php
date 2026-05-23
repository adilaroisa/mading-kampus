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
    </style>
</head>
<body class="antialiased">
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b-4 border-gray-900 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter">Campus<span class="text-indigo-600">Hub</span></h1>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : route('bookmarks.index') }}" 
                       class="font-black bg-gray-900 text-white px-6 py-2 rounded-full hover:bg-indigo-600 transition">
                        {{ auth()->user()->role === 'admin' ? 'Dashboard' : 'Simpanan' }}
                    </a>
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