<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi akun dan foto profil Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" x-data="{
            photoPreview: null,
            imageUrl: null,
            removeAvatar: false,
            showPreviewModal: false,
            rotation: 0,
            selectedFileName: '',
            hasExistingAvatar: {{ $user->avatar ? 'true' : 'false' }},
            handleFileChange() {
                const file = this.$refs.avatar.files[0];
                if (!file) return;
                this.selectedFileName = file.name;
                this.removeAvatar = false;
                this.rotation = 0;
                if (this.imageUrl) URL.revokeObjectURL(this.imageUrl);
                this.imageUrl = URL.createObjectURL(file);
                this.photoPreview = this.imageUrl;
                this.showPreviewModal = true;
                this.$dispatch('avatar-changed');
            },
            resetFileInput() {
                this.$refs.avatar.value = null;
                if (this.imageUrl) URL.revokeObjectURL(this.imageUrl);
                this.imageUrl = null;
                this.photoPreview = null;
                this.selectedFileName = '';
                this.rotation = 0;
            },
            rotateImage() {
                this.rotation = (this.rotation + 90) % 360;
            },
            async _drawAndPrepareFile() {
                const file = this.$refs.avatar.files[0];
                if (!file || !this.imageUrl) return;

                const img = await new Promise((resolve, reject) => {
                    const image = new Image();
                    image.onload = () => resolve(image);
                    image.onerror = reject;
                    image.src = this.imageUrl;
                });

                const size = Math.min(img.naturalWidth, img.naturalHeight);
                const canvas = this.$refs.cropCanvas;
                canvas.width = size;
                canvas.height = size;
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, size, size);
                ctx.save();
                ctx.translate(size / 2, size / 2);
                ctx.rotate(this.rotation * Math.PI / 180);
                const sx = (img.naturalWidth - size) / 2;
                const sy = (img.naturalHeight - size) / 2;
                ctx.drawImage(img, sx, sy, size, size, -size / 2, -size / 2, size, size);
                ctx.restore();

                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.9));
                if (!blob) return;
                const newFile = new File([blob], this.selectedFileName || 'avatar.jpg', { type: 'image/jpeg' });
                const dt = new DataTransfer();
                dt.items.add(newFile);
                this.$refs.avatar.files = dt.files;
                this.photoPreview = URL.createObjectURL(blob);
                this.hasExistingAvatar = true;
            },
            async savePreview() {
                await this._drawAndPrepareFile();
                this.rotation = 0;
                this.showPreviewModal = false;
            },
            cancelPreview() {
                if (this.photoPreview) {
                    this.resetFileInput();
                }
                this.showPreviewModal = false;
            },
            async submitForm(event) {
                event.preventDefault();
                if (this.photoPreview) {
                    await this._drawAndPrepareFile();
                }
                this.$el.submit();
            }
        }" x-ref="profileForm" @submit.prevent="submitForm">
        @csrf
        @method('patch')

        <div class="col-span-6 sm:col-span-4">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <input type="file" id="avatar" name="avatar" class="hidden"
                   accept="image/*"
                   capture="environment"
                   x-ref="avatar"
                   @change="handleFileChange()" />

            <input type="hidden" name="remove_avatar" value="0" x-bind:value="removeAvatar ? 1 : 0">
            <canvas x-ref="cropCanvas" class="hidden"></canvas>

            <div class="mt-2 flex flex-col sm:flex-row sm:items-center sm:gap-5 gap-4">
                <div class="relative w-20 h-20">
                    <div class="w-full h-full rounded-full overflow-hidden border-2 border-purple-100 shadow-sm bg-gray-100 flex items-center justify-center">
                        <button type="button" x-show="photoPreview || (!removeAvatar && hasExistingAvatar)" @click="showPreviewModal = true" class="w-full h-full flex items-center justify-center focus:outline-none">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview && !removeAvatar && hasExistingAvatar">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </template>
                        </button>
                        <template x-if="removeAvatar || (!photoPreview && !hasExistingAvatar)">
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-purple-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        </template>
                    </div>

                    <button type="button" aria-label="Edit foto profil" @click.prevent="$refs.avatar.click(); removeAvatar = false"
                            class="absolute -right-1 -bottom-1 bg-white p-1.5 rounded-full ring-2 ring-white shadow text-purple-600 hover:bg-purple-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9a1 1 0 01-.464.263l-4 1a1 1 0 01-1.213-1.213l1-4a1 1 0 01.263-.464l9.9-9.9a2 2 0 012.828 0zM15.121 4.95l-1.06 1.06L13 4.95l1.06-1.06 1.06 1.06z" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-2">
                    <button type="button" 
                            class="px-4 py-2 border border-purple-200 rounded-2xl text-sm font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 transition duration-200"
                            @click.prevent="$refs.avatar.click()">
                        Pilih Foto Baru
                    </button>
                    <p class="text-xs text-gray-500">Hanya PNG, JPG, GIF. Maks. 2MB.</p>
                    <p x-show="removeAvatar" class="text-xs text-red-500">Foto akan dihapus saat menyimpan.</p>
                </div>
            
            <!-- Preview Modal -->
            <div x-show="showPreviewModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/50" @click="cancelPreview()"></div>

                <div class="relative bg-white rounded-3xl shadow-lg max-w-xl w-full mx-4 overflow-hidden">
                    <div class="p-3 border-b border-gray-200 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <span class="text-base">Foto Profil</span>
                            <button type="button" aria-label="Rotasi" x-show="photoPreview"
                                    @click.prevent="rotateImage()"
                                    class="bg-white px-3 py-2 rounded-2xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                Rotasi
                            </button>
                        </div>

                        <button type="button" aria-label="Tutup preview" @click.prevent="cancelPreview()"
                                class="bg-white p-2 rounded-full text-gray-600 hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 flex flex-col items-center justify-center gap-4">
                        <div class="w-64 h-64 md:w-72 md:h-72 rounded-3xl overflow-hidden bg-gray-100 flex items-center justify-center">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" :style="`transform: rotate(${rotation}deg);`" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview && hasExistingAvatar">
                                <img src="{{ asset('storage/' . $user->avatar) }}" :style="`transform: rotate(${rotation}deg);`" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview && !hasExistingAvatar">
                                <div class="w-full h-full flex items-center justify-center text-5xl font-bold text-purple-600">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </template>
                        </div>

                        <div class="w-full flex flex-col sm:flex-row justify-end gap-3">
                            <button type="button" @click.prevent="cancelPreview()"
                                    class="w-full sm:w-auto px-5 py-2 rounded-2xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="button" x-show="photoPreview"
                                    @click.prevent="savePreview()"
                                    class="w-full sm:w-auto px-5 py-2 rounded-2xl bg-purple-600 text-sm font-semibold text-white hover:bg-purple-700 transition">
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-purple-500 focus:ring-purple-500 rounded-2xl border-gray-300" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:border-purple-500 focus:ring-purple-500 rounded-2xl border-gray-300" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 border-none px-6 py-2.5 rounded-2xl shadow-sm tracking-wide">
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>