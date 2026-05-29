<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-6 rounded-3xl shadow-lg mt-4 border-b-4 border-indigo-300 flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-white tracking-wide flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Artikel Mading
            </h2>
            <a href="{{ route('admin.articles.index') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 transition rounded-xl shadow p-3 flex items-center justify-center" aria-label="Batal dan kembali ke Kelola Artikel">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Judul Artikel</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" x-data="{ 
                        categoryId: '{{ old('category_id', $article->category_id) }}', 
                        eventCatId: '{{ $eventCategoryId }}',
                        isEvent() { return this.categoryId == this.eventCatId; }
                    }">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                            <select name="category_id" x-model="categoryId" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tanggal & Waktu Pelaksanaan</label>
                                <input type="datetime-local" name="event_date" value="{{ old('event_date', $article->event_date ? \Carbon\Carbon::parse($article->event_date)->format('Y-m-d\TH:i') : '') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                            </div>
                            <div x-show="isEvent()" x-cloak x-transition>
                                <label class="block text-gray-700 font-bold mb-2">Lokasi Pelaksanaan</label>
                                <input type="text" name="event_location" value="{{ old('event_location', $article->event_location) }}" placeholder="Contoh: Gedung Serba Guna / Link Zoom" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                            </div>
                            
                            <div class="pt-2">
                                <label class="block text-gray-700 font-bold mb-1">Tanggal Kedaluwarsa (Opsional)</label>
                                <p class="text-xs text-gray-500 mb-2">Mading otomatis hilang dari beranda setelah tanggal ini.</p>
                                <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $article->expires_at ? \Carbon\Carbon::parse($article->expires_at)->format('Y-m-d\TH:i') : '') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6" x-data="{
                            imageUrl: '{{ $article->image ? asset('storage/' . $article->image) : '' }}',
                            isDragging: false,
                            previewing: false,
                            handleDrop(event) {
                                this.isDragging = false;
                                const files = event.dataTransfer.files;
                                if (files.length > 0) {
                                    document.getElementById('image-upload').files = files;
                                    this.previewImage(files[0]);
                                }
                            },
                            handleFileSelect(event) {
                                const files = event.target.files;
                                if (files.length > 0) {
                                    this.previewImage(files[0]);
                                }
                            },
                            previewImage(file) {
                                const reader = new FileReader();
                                reader.onload = (e) => this.imageUrl = e.target.result;
                                reader.readAsDataURL(file);
                            }
                        }">
                        <label class="block text-gray-700 font-bold mb-2">Ganti Poster (Opsional)</label>
                        <div 
                            class="mt-1 w-full min-h-[200px] border-2 border-dashed rounded-xl transition-colors duration-200 ease-in-out relative group flex items-center justify-center"
                            :class="isDragging ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                        >
                            <!-- Input File Asli -->
                            <input id="image-upload" name="image" type="file" class="sr-only" @change="handleFileSelect($event)" accept="image/png, image/jpeg, image/gif">

                            <template x-if="!imageUrl">
                                <label for="image-upload" class="flex flex-col items-center justify-center px-6 pt-8 pb-10 cursor-pointer w-full h-full absolute inset-0 z-10">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center w-full mt-4">
                                        <span class="font-medium text-indigo-600 hover:text-indigo-500">Pilih file</span>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF hingga 2MB (Tampilan akan melebar dan rapi)</p>
                                </label>
                            </template>
                            
                            <template x-if="imageUrl">
                                <div class="relative w-full p-2">
                                    <img :src="imageUrl" class="w-full max-h-[400px] object-contain rounded-lg bg-gray-900/5" />
                                    
                                    <!-- Overlay Actions -->
                                    <div class="absolute inset-2 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex flex-col items-center justify-center gap-3">
                                        <div class="flex gap-3">
                                            <button type="button" @click.stop="previewing = true" class="bg-white/90 hover:bg-white text-gray-800 p-2.5 rounded-full shadow-lg transform hover:scale-110 transition cursor-pointer" title="Preview Gambar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                            </button>
                                            <label for="image-upload" class="bg-indigo-600/90 hover:bg-indigo-600 text-white p-2.5 rounded-full shadow-lg transform hover:scale-110 transition cursor-pointer flex items-center justify-center" title="Ganti Gambar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </label>
                                        </div>
                                        <span class="text-white text-sm font-medium">Klik untuk mengubah atau melihat ukuran penuh</span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Modal Preview -->
                        <div x-show="previewing" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-white/95 backdrop-blur-sm" style="display: none;" @click="previewing = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                            <img :src="imageUrl" class="max-w-[85vw] max-h-[85vh] rounded-2xl shadow-2xl border border-gray-200" @click.stop>
                            <button type="button" @click="previewing = false" class="absolute top-6 right-6 text-gray-500 hover:text-gray-900 bg-white hover:bg-gray-100 rounded-full p-3 transition shadow-lg border border-gray-200 z-50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Konten / Isi Artikel</label>
                        <textarea name="content" rows="8" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">{{ old('content', $article->content) }}</textarea>
                    </div>

                    <div class="mb-8 bg-indigo-50 p-4 rounded-xl border border-indigo-200">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_pinned" value="1" {{ $article->is_pinned ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-400 border-gray-300 w-5 h-5 shadow-sm">
                            <span class="ml-3 text-sm font-bold text-indigo-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Sematkan di Atas (Pin Announcement)
                            </span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-extrabold text-lg py-3 px-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>