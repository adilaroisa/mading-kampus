<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - CampusHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700,800&display=swap" rel="stylesheet" />
    <style> body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; } </style>
</head>
<body class="antialiased text-gray-800">
    <nav class="bg-gradient-to-r from-indigo-500 to-teal-400 p-4 shadow-lg rounded-b-3xl mb-8">
        <div class="max-w-4xl mx-auto flex justify-between items-center px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-extrabold text-white tracking-wider">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                CampusHub
            </a>
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-white bg-white/20 hover:bg-white/30 font-semibold px-4 py-2 rounded-full text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 mb-16">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-6 md:p-8">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                <span class="flex items-center gap-1 bg-teal-100 text-teal-800 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wide">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    {{ $article->category->name ?? 'Umum' }}
                </span>
                <div class="flex items-center gap-3 text-sm text-gray-400 font-medium">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ $article->views_count }} Views
                    </span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $article->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <h1 class="text-3xl md:text-4xl font-black text-indigo-950 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            @if($article->image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-md max-h-96 w-full bg-gray-50 flex justify-center">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="Poster Pengumuman" class="object-contain w-full h-full">
                </div>
            @endif

            <div class="text-gray-700 leading-relaxed text-base md:text-lg whitespace-pre-line border-b border-gray-100 pb-8">
                {{ $article->content }}
            </div>
            
            <div class="pt-4 text-sm text-gray-400 font-semibold flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Diterbitkan oleh: <span class="text-indigo-600">{{ $article->author->name }}</span>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">
            <h3 class="text-xl font-bold text-indigo-950 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Ruang Diskusi Kampus ({{ $article->comments->count() }})
            </h3>

            @auth
                <form method="POST" action="{{ route('comments.store', $article->id) }}" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <textarea name="body" rows="3" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-sm" placeholder="Tulis tanggapan atau pertanyaanmu di sini..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-full text-sm shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            @else
                <div class="flex items-center justify-center gap-2 bg-yellow-50 text-yellow-800 p-4 rounded-2xl border border-yellow-200 text-sm mb-8 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Kamu harus <a href="{{ route('login') }}" class="underline font-bold text-indigo-600">Masuk / Login</a> terlebih dahulu untuk ikut berdiskusi.</span>
                </div>
            @endauth

            <div class="space-y-4">
                @forelse($article->comments as $comment)
                    <div x-data="{ editing: false }" class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="font-bold text-gray-900 text-sm">{{ $comment->user->name }}</span>
                                @if($comment->is_edited)
                                    <span class="text-xs text-gray-400 italic ml-2">(diedit)</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                
                                @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                                    <div class="flex gap-2">
                                        @if(auth()->id() === $comment->user_id)
                                            <button @click="editing = !editing" class="text-gray-400 hover:text-indigo-600 transition" title="Edit Komentar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                        @endif
                                        <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" onsubmit="return confirm('Hapus komentar ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Hapus Komentar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div x-show="!editing">
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->body }}</p>
                        </div>

                        <form x-show="editing" method="POST" action="{{ route('comments.update', $comment->id) }}" class="mt-3" style="display: none;">
                            @csrf @method('PUT')
                            <textarea name="body" required class="w-full bg-white border border-gray-300 rounded-lg p-3 text-sm focus:ring-indigo-400">{{ $comment->body }}</textarea>
                            <div class="flex justify-end gap-2 mt-2">
                                <button type="button" @click="editing = false" class="text-sm px-3 py-1 text-gray-500 hover:bg-gray-100 rounded flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Batal
                                </button>
                                <button type="submit" class="text-sm px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-6 text-sm flex flex-col items-center">
                        <svg class="w-8 h-8 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Belum ada diskusi di mading ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>