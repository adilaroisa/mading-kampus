<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');
        .mading-img { aspect-ratio: 4/3; object-fit: cover; }
        .float-card { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .float-card:hover { transform: translateY(-10px); }
        [x-cloak] { display: none !important; }
        .dropdown-enter { animation: dropIn 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes dropIn { from { opacity: 0; transform: translateY(-8px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    </style>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-6">Update Hari Ini.</h2>
                
                <div class="relative z-30 flex flex-wrap gap-3">
                    <a href="/" class="px-6 py-3 rounded-full font-bold {{ !request()->has('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white border-2 border-gray-200 hover:border-indigo-300 transition' }}">
                        # Semua
                    </a>
                    @foreach(\App\Models\Category::all() as $cat)
                        <a href="/?category={{ $cat->slug }}" class="px-6 py-3 rounded-full font-bold transition-all transform hover:scale-105 {{ request('category') == $cat->slug ? 'bg-purple-600 text-white shadow-lg shadow-purple-200' : 'bg-white border-2 border-gray-200 hover:border-indigo-300' }}">
                            # {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $article)
                <a href="{{ route('articles.show', $article->slug) }}" class="flex flex-col h-full float-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden border border-gray-100 relative group">
                    <div class="relative overflow-hidden bg-gray-100">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" class="mading-img w-full group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="mading-img w-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-gray-400 font-bold group-hover:scale-105 transition-transform duration-500">No Image</div>
                        @endif
                        <span class="absolute top-4 left-4 px-3 py-1.5 bg-indigo-600 text-white font-bold text-xs uppercase rounded-full shadow-md z-10">
                            {{ $article->category->name }}
                        </span>
                        @if($article->is_pinned)
                            <div class="absolute top-4 right-4 w-9 h-9 bg-black/40 backdrop-blur-md text-white rounded-full z-10 border border-white/20 flex items-center justify-center shadow-[0_4px_10px_rgba(0,0,0,0.3)]">
                                <svg class="w-4 h-4 transform rotate-45 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M16 11V5.5C16 4.67 15.33 4 14.5 4h-5C8.67 4 8 4.67 8 5.5V11L6.5 14v1h4v6l1.5 1.5L13.5 21v-6h4v-1L16 11z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h2 class="text-lg font-extrabold text-gray-900 mb-3 leading-tight line-clamp-2 group-hover:text-indigo-600 transition">{{ $article->title }}</h2>
                        <p class="text-gray-600 mb-4 font-medium text-sm flex-grow line-clamp-2">{{ Str::limit($article->content, 80) }}</p>
                        
                        <div class="mt-4 block w-full py-3 text-center rounded-xl bg-indigo-50 text-indigo-700 font-bold group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 text-sm">
                            Baca Selengkapnya
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-4xl font-black text-gray-300">Belum ada mading nih.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>