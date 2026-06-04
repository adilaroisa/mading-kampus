<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - DiMadingin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700,800&display=swap" rel="stylesheet" />
    <style> 
        body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; } 
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
        <nav class="bg-gradient-to-r from-indigo-500 to-purple-500 p-4 shadow-lg rounded-b-3xl mb-8">
            <div class="flex justify-between items-center px-2 md:px-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-extrabold text-white tracking-wider">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    DiMadingin
                </a>
                <a href="{{ route('home') }}" class="flex items-center justify-center text-white bg-white/20 hover:bg-white/30 p-2.5 rounded-full transition w-10 h-10" title="Kembali ke Beranda">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
            </div>
        </nav>
    </div>

    <div class="max-w-4xl mx-auto px-4 mb-16">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
                <div class="flex flex-col gap-3 flex-1">
                    <span class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-800 text-xs px-3 py-1.5 rounded-full font-bold uppercase tracking-wide w-max">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        {{ $article->category->name ?? 'Umum' }}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-tight tracking-tight mt-1">
                        {{ $article->title }}
                    </h1>
                </div>

                <div class="flex flex-col items-end gap-3 shrink-0">
                    <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ $article->views_count }} Views
                        </span>
                    </div>

                    @auth
                        @if(auth()->user()->role !== 'admin')
                            <form action="{{ route('articles.bookmark', $article->id) }}" method="POST" class="mt-1">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl transition border-2 {{ auth()->user()->bookmarks->contains($article->id) ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-200 hover:bg-indigo-700' : 'bg-white text-indigo-600 border-indigo-200 hover:border-indigo-400 hover:bg-indigo-50 shadow-sm' }}">
                                    <svg class="w-4 h-4" fill="{{ auth()->user()->bookmarks->contains($article->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                    <span>{{ auth()->user()->bookmarks->contains($article->id) ? 'Tersimpan' : 'Simpan' }}</span>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            @if($article->event_date)
                <div class="mb-8 p-6 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-100 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
                    <div class="flex-1 space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Pelaksanaan</p>
                                <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($article->event_date)->translatedFormat('l, d F Y - H:i') }} WIB</p>
                            </div>
                        </div>
                        
                        @if($article->event_location)
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi / Media</p>
                                    <p class="text-gray-800 font-medium">{{ $article->event_location }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($article->image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-md w-full bg-gray-50 flex justify-center">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="Poster Pengumuman" class="object-contain w-full h-auto">
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

        <!-- Bagian Komentar Alpine.js -->
        <div x-data="commentsApp()" x-cloak class="mt-8 bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">
            <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Ruang Diskusi (<span x-text="comments.length + comments.reduce((acc, c) => acc + (c.replies ? c.replies.length : 0), 0)"></span>)
            </h3>

            @auth
                <div class="flex gap-3 mb-8 items-start pb-6 border-b border-gray-100">
                    <div class="flex-shrink-0 mt-0.5">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-10 h-10 rounded-full object-cover shadow-sm border border-gray-100">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <form @submit.prevent="addComment(null, newComment)" class="flex-1 relative">
                        <input type="text" x-model="newComment" required class="w-full bg-gray-50 border border-gray-200 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 rounded-full pl-5 pr-12 py-2.5 text-sm transition-all shadow-inner" placeholder="Tambahkan komentar..." :disabled="isSubmitting">
                        <button type="submit" :disabled="isSubmitting" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-full transition shadow-md disabled:opacity-50">
                            <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center justify-center gap-2 bg-indigo-50 text-indigo-800 p-4 rounded-2xl border border-indigo-200 text-sm mb-8 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Kamu harus <a href="{{ route('login') }}" class="underline font-bold text-indigo-600 hover:text-indigo-700">Masuk / Login</a> terlebih dahulu untuk ikut berdiskusi.</span>
                </div>
            @endauth

            <div class="space-y-6">
                <template x-for="comment in comments" :key="comment.id">
                    <div x-data="{ editing: false, editBody: comment.body, replying: false, replyBody: '', showAllReplies: false }" class="group flex gap-3">
                        
                        <!-- Avatar Profil -->
                        <div class="flex-shrink-0 mt-1">
                            <template x-if="comment.user.avatar">
                                <img :src="'/storage/' + comment.user.avatar" class="w-9 h-9 rounded-full object-cover shadow-sm border border-gray-100">
                            </template>
                            <template x-if="!comment.user.avatar">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-gray-400 to-gray-500 text-white flex items-center justify-center font-bold text-sm shadow-sm" x-text="comment.user.name.charAt(0).toUpperCase()"></div>
                            </template>
                        </div>

                        <!-- Konten Komentar Utama -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-bold text-gray-900 text-[13px] mr-1" x-text="comment.user.name"></span>
                                    <span class="text-[11px] text-gray-400 font-medium" x-text="formatDate(comment.created_at)"></span>
                                    <template x-if="comment.is_edited">
                                        <span class="text-[10px] text-gray-400 ml-1">(diedit)</span>
                                    </template>
                                </div>
                                
                                @if(auth()->check())
                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity" x-show="parseInt('{{ auth()->id() }}') === comment.user_id || '{{ auth()->user()->role }}' === 'admin'">
                                        <button x-show="parseInt('{{ auth()->id() }}') === comment.user_id" @click="editing = !editing; replying = false; editBody = comment.body" class="text-gray-400 hover:text-indigo-600 transition" title="Edit Komentar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button @click="deleteComment(comment.id)" class="text-gray-400 hover:text-red-500 transition" title="Hapus Komentar">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div x-show="!editing" class="mt-0.5">
                                <p class="text-gray-800 text-[13px] leading-snug" x-text="comment.body"></p>
                            </div>

                            <!-- Form Edit -->
                            <form x-show="editing" @submit.prevent="updateComment(comment.id, editBody); editing = false" class="mt-2" style="display: none;">
                                <div class="flex items-center gap-2">
                                    <input type="text" x-model="editBody" required class="flex-1 bg-gray-50 border-none rounded-full px-4 py-1.5 text-xs focus:ring-1 focus:ring-indigo-400">
                                    <button type="submit" class="text-indigo-600 font-bold text-xs hover:text-indigo-800 transition">Simpan</button>
                                    <button type="button" @click="editing = false" class="text-gray-400 font-bold text-xs hover:text-gray-600 transition">Batal</button>
                                </div>
                            </form>

                            <!-- Tombol Balas -->
                            @auth
                                <div x-show="!editing" class="mt-1">
                                    <button @click="replying = !replying; editing = false; replyBody = `@${comment.user.name} `;" class="text-[11px] font-bold text-gray-500 hover:text-gray-800 transition">Balas</button>
                                </div>
                            @endauth

                            <!-- Form Balas (Sleek Inline) -->
                            @auth
                                <form x-show="replying" @submit.prevent="addComment(comment.id, replyBody); replying = false" class="mt-2 flex items-center gap-2" style="display: none;">
                                    <div class="flex-shrink-0">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-6 h-6 rounded-full object-cover">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-[10px]">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="relative flex-1">
                                        <input type="text" x-model="replyBody" x-ref="replyInput" required class="w-full bg-gray-100 border-transparent focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 rounded-full pl-4 pr-10 py-1.5 text-xs transition-all">
                                        <button type="submit" :disabled="isSubmitting" class="absolute right-1 top-1/2 -translate-y-1/2 text-indigo-500 hover:text-indigo-700 p-1.5 rounded-full hover:bg-indigo-50 transition">
                                            <svg class="w-3.5 h-3.5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        </button>
                                    </div>
                                </form>
                            @endauth

                            <!-- Area Balasan (Replies) - Flat IG Style -->
                            <template x-if="comment.replies && comment.replies.length > 0">
                                <div class="mt-3 space-y-4">
                                    <template x-for="(reply, index) in comment.replies" :key="reply.id">
                                        <div x-show="showAllReplies || index < 2" x-data="{ editingReply: false, editReplyBody: reply.body }" class="group flex gap-3">
                                            <div class="flex-shrink-0 mt-1">
                                                <template x-if="reply.user.avatar">
                                                    <img :src="'/storage/' + reply.user.avatar" class="w-7 h-7 rounded-full object-cover shadow-sm border border-gray-100">
                                                </template>
                                                <template x-if="!reply.user.avatar">
                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-gray-400 to-gray-500 text-white flex items-center justify-center font-bold text-[10px] shadow-sm" x-text="reply.user.name.charAt(0).toUpperCase()"></div>
                                                </template>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <span class="font-bold text-gray-900 text-[13px] mr-1" x-text="reply.user.name"></span>
                                                        <span class="text-[11px] text-gray-400 font-medium" x-text="formatDate(reply.created_at)"></span>
                                                        <template x-if="reply.is_edited">
                                                            <span class="text-[10px] text-gray-400 ml-1">(diedit)</span>
                                                        </template>
                                                    </div>

                                                    @if(auth()->check())
                                                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity" x-show="parseInt('{{ auth()->id() }}') === reply.user_id || '{{ auth()->user()->role }}' === 'admin'">
                                                            <button x-show="parseInt('{{ auth()->id() }}') === reply.user_id" @click="editingReply = !editingReply; editReplyBody = reply.body" class="text-gray-400 hover:text-indigo-600 transition" title="Edit Balasan">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                            </button>
                                                            <button @click="deleteComment(reply.id, comment.id)" class="text-gray-400 hover:text-red-500 transition" title="Hapus Balasan">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div x-show="!editingReply" class="mt-0.5">
                                                    <!-- Highlight @username if it starts with one -->
                                                    <p class="text-gray-800 text-[13px] leading-snug" x-html="highlightMention(reply.body)"></p>
                                                </div>

                                                <!-- Form Edit Balasan -->
                                                <form x-show="editingReply" @submit.prevent="updateComment(reply.id, editReplyBody, comment.id); editingReply = false" class="mt-1.5" style="display: none;">
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" x-model="editReplyBody" required class="flex-1 bg-gray-50 border-none rounded-full px-3 py-1.5 text-xs focus:ring-1 focus:ring-indigo-400">
                                                        <button type="submit" class="text-indigo-600 font-bold text-xs hover:text-indigo-800 transition">Simpan</button>
                                                        <button type="button" @click="editingReply = false" class="text-gray-400 font-bold text-xs hover:text-gray-600 transition">Batal</button>
                                                    </div>
                                                </form>
                                                
                                                <!-- Tombol Balas (ke Balasan ini) -->
                                                @auth
                                                    <div x-show="!editingReply" class="mt-1">
                                                        <!-- Menggunakan commenting root id (comment.id), tapi tagging @reply.user.name -->
                                                        <button @click="replying = true; editing = false; replyBody = `@${reply.user.name} `; setTimeout(() => $refs.replyInput.focus(), 100);" class="text-[11px] font-bold text-gray-500 hover:text-gray-800 transition">Balas</button>
                                                    </div>
                                                @endauth
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <!-- Tombol Load More Replies -->
                                    <div x-show="comment.replies.length > 2" class="mt-2">
                                        <button @click="showAllReplies = !showAllReplies" class="text-[11px] font-bold text-indigo-500 hover:text-indigo-700 flex items-center gap-1 transition">
                                            <svg class="w-3 h-3 transition-transform" :class="showAllReplies ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            <span x-text="showAllReplies ? 'Sembunyikan balasan' : 'Lihat ' + (comment.replies.length - 2) + ' balasan lainnya...'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <div x-show="comments.length === 0" class="text-center text-gray-400 py-10 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <span class="text-sm font-semibold">Belum ada komentar</span>
                    <span class="text-xs mt-1">Jadilah yang pertama memulai diskusi!</span>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('commentsApp', () => ({
                comments: @json($article->comments),
                newComment: '',
                isSubmitting: false,

                formatDate(dateString) {
                    if(!dateString) return 'baru saja';
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffMs = now - date;
                    const diffMins = Math.floor(diffMs / 60000);
                    if (diffMins < 1) return 'baru saja';
                    if (diffMins < 60) return diffMins + 'm';
                    const diffHrs = Math.floor(diffMins / 60);
                    if (diffHrs < 24) return diffHrs + 'j';
                    const diffDays = Math.floor(diffHrs / 24);
                    return diffDays + 'h';
                },
                
                highlightMention(text) {
                    if (!text) return '';
                    // Highlight kata pertama jika berawalan @
                    return text.replace(/^@(\w+)/, '<span class="text-indigo-500 font-bold">@$1</span>');
                },

                async addComment(parentId = null, text = null) {
                    const body = text !== null ? text : this.newComment;
                    if (!body.trim()) return;

                    this.isSubmitting = true;

                    try {
                        const response = await fetch('{{ route('comments.store', $article->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                body: body,
                                parent_id: parentId
                            })
                        });

                        const data = await response.json();
                        
                        if (data.status === 'success') {
                            if (!parentId) {
                                data.comment.replies = [];
                                this.comments.unshift(data.comment);
                                this.newComment = '';
                            } else {
                                const parentIndex = this.comments.findIndex(c => c.id === parentId);
                                if (parentIndex !== -1) {
                                    if (!this.comments[parentIndex].replies) {
                                        this.comments[parentIndex].replies = [];
                                    }
                                    this.comments[parentIndex].replies.push(data.comment);
                                }
                            }
                        }
                    } catch(e) {
                        console.error('Error adding comment', e);
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                async updateComment(commentId, newBody, parentId = null) {
                    if (!newBody.trim()) return;
                    
                    try {
                        const response = await fetch(`/comments/${commentId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ body: newBody })
                        });
                        
                        const data = await response.json();
                        
                        if (data.status === 'success') {
                            let target = null;
                            if (!parentId) {
                                target = this.comments.find(c => c.id === commentId);
                            } else {
                                const parent = this.comments.find(c => c.id === parentId);
                                if (parent) {
                                    target = parent.replies.find(r => r.id === commentId);
                                }
                            }
                            if (target) {
                                target.body = newBody;
                                target.is_edited = true;
                            }
                        }
                    } catch(e) {
                        console.error('Error updating comment', e);
                    }
                },

                async deleteComment(commentId, parentId = null) {
                    if(!confirm('Hapus komentar ini?')) return;
                    
                    try {
                        const response = await fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.status === 'success') {
                            if (!parentId) {
                                this.comments = this.comments.filter(c => c.id !== commentId);
                            } else {
                                const parent = this.comments.find(c => c.id === parentId);
                                if (parent) {
                                    parent.replies = parent.replies.filter(r => r.id !== commentId);
                                }
                            }
                        }
                    } catch(e) {
                        console.error('Error deleting comment', e);
                    }
                }
            }));
        });
    </script>
</body>
</html>