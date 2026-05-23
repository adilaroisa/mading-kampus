<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 p-6 rounded-3xl shadow-lg mt-4 border-b-4 border-orange-300 flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-white tracking-wide flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tulis Artikel Mading Baru
            </h2>
            <a href="{{ route('admin.articles.index') }}" class="bg-white text-orange-600 font-bold px-4 py-2 rounded-xl text-sm shadow hover:bg-orange-50 transition">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Judul Artikel</label>
                        <input type="text" name="title" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition" placeholder="Masukkan judul mading yang menarik...">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                            <select name="category_id" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div x-data="{
                                imageUrl: null,
                                isDragging: false,
                                handleDrop(event) {
                                    this.isDragging = false;
                                    const files = event.dataTransfer.files;
                                    if (files.length > 0) {
                                        this.$refs.fileInput.files = files;
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
                            <label class="block text-gray-700 font-bold mb-2">Upload Poster / Gambar</label>
                            <div 
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-xl transition-colors duration-200 ease-in-out cursor-pointer relative"
                                :class="isDragging ? 'border-orange-500 bg-orange-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                @click="$refs.fileInput.click()"
                            >
                                <div class="space-y-2 text-center">
                                    <svg x-show="!imageUrl" class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    
                                    <template x-if="imageUrl">
                                        <img :src="imageUrl" class="mx-auto h-32 object-cover rounded-lg shadow-sm border border-gray-200" />
                                    </template>

                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                            <span x-text="imageUrl ? 'Ganti file' : 'Pilih file'"></span>
                                            <input id="file-upload" x-ref="fileInput" name="image" type="file" class="sr-only" @change="handleFileSelect($event)" accept="image/png, image/jpeg, image/gif">
                                        </label>
                                        <p class="pl-1" x-show="!imageUrl">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500" x-show="!imageUrl">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Konten / Isi Artikel</label>
                        <textarea name="content" rows="8" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition" placeholder="Tuliskan isi pengumuman mading secara detail di sini..."></textarea>
                    </div>

                    <div class="mb-8 bg-orange-50 p-4 rounded-xl border border-orange-200">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_pinned" value="1" class="rounded text-orange-500 focus:ring-orange-400 border-gray-300 w-5 h-5 shadow-sm">
                            <span class="ml-3 text-sm font-bold text-orange-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Sematkan di Atas (Pin Announcement)
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-extrabold py-3 rounded-xl shadow-lg transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Terbitkan Pengumuman Mading
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>