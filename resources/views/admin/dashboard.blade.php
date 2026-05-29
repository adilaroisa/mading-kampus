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
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Artikel -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Mading</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ $totalArticles }}</h3>
                    </div>
                </div>

                <!-- Total Views -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="bg-blue-50 p-4 rounded-2xl text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Audiens</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ $totalViews }}</h3>
                    </div>
                </div>

                <!-- Total Komentar -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="bg-purple-50 p-4 rounded-2xl text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Komentar</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ $totalComments }}</h3>
                    </div>
                </div>
            </div>

            <!-- Content Area (Comments & Quick Actions) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Kiri: Riwayat Komentar (2 Kolom) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-full">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                                Riwayat Komentar Terbaru
                            </h3>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($recentComments as $comment)
                                <div x-data="{ editing: false }" class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex gap-4 group">
                                    <div class="flex-shrink-0">
                                        @if($comment->user->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-10 h-10 rounded-full object-cover border border-white shadow-sm" alt="{{ $comment->user->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-purple-200 text-purple-700 flex items-center justify-center font-bold shadow-sm">
                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex items-baseline gap-2">
                                                <h4 class="font-bold text-gray-900 text-sm">{{ $comment->user->name }}</h4>
                                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                @if($comment->is_edited)
                                                    <span class="text-[10px] text-gray-400">(diedit)</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Ikon Edit/Hapus (Muncul saat Hover) -->
                                            @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    @if(auth()->id() === $comment->user_id)
                                                        <button @click="editing = !editing" class="text-gray-400 hover:text-indigo-600 transition" title="Edit Komentar">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        </button>
                                                    @endif
                                                    <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" onsubmit="return confirm('Hapus komentar ini?');" class="flex items-center">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Hapus Komentar">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>

                                        <p class="text-xs text-indigo-600 mb-2">
                                            Mengomentari: <a href="{{ route('articles.show', $comment->article->slug) }}" class="font-medium hover:underline">{{ Str::limit($comment->article->title, 40) }}</a>
                                        </p>
                                        
                                        <!-- Teks Komentar -->
                                        <div x-show="!editing">
                                            <p class="text-sm text-gray-700 bg-white p-3 rounded-xl border border-gray-100">
                                                {{ Str::limit($comment->body, 100) }}
                                            </p>
                                        </div>

                                        <!-- Form Edit Komentar -->
                                        <form x-show="editing" method="POST" action="{{ route('comments.update', $comment->id) }}" class="mt-2" style="display: none;">
                                            @csrf @method('PUT')
                                            <div class="flex items-center gap-2">
                                                <input type="text" name="body" required class="flex-1 bg-white border border-gray-200 rounded-full px-4 py-1.5 text-sm focus:ring-2 focus:ring-indigo-400" value="{{ $comment->body }}">
                                                <button type="submit" class="text-indigo-600 font-bold text-xs hover:text-indigo-800 transition bg-indigo-50 px-3 py-1.5 rounded-full">Simpan</button>
                                                <button type="button" @click="editing = false" class="text-gray-400 font-bold text-xs hover:text-gray-600 transition">Batal</button>
                                            </div>
                                        </form>

                                        <div class="mt-3">
                                            <a href="{{ route('articles.show', $comment->article->slug) }}#comment-{{ $comment->id }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-1 inline-flex">
                                                <svg class="w-3 h-3 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                Balas / Lihat di Artikel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <p class="text-gray-500 font-medium">Belum ada komentar sama sekali.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Kanan: Akses Cepat (1 Kolom Stack Vertikal) -->
                <div class="space-y-4">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2 mb-6 ml-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Akses Cepat
                    </h3>
                    
                    <a href="{{ route('admin.articles.index') }}" class="group flex items-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="bg-blue-50 p-3 rounded-xl text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Kelola Artikel</h4>
                            <p class="text-xs text-gray-500">Edit, atau hapus artikel aktif.</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.articles.create') }}" class="group flex items-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition-all duration-300">
                        <div class="bg-purple-50 p-3 rounded-xl text-purple-600 mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Buat Baru</h4>
                            <p class="text-xs text-gray-500">Tambah pengumuman mading.</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.articles.archive') }}" class="group flex items-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-red-200 transition-all duration-300">
                        <div class="bg-red-50 p-3 rounded-xl text-red-600 mr-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 group-hover:text-red-600 transition-colors">Arsip Mading</h4>
                            <p class="text-xs text-gray-500">Lihat mading kedaluwarsa.</p>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>