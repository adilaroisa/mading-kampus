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
            isCropping: false,
            selectedFileName: '',
            cropper: null,
            isUploading: false,
            showToast: false,
            toastMessage: '',
            hasExistingAvatar: {{ $user->avatar ? 'true' : 'false' }},
            handleFileChange() {
                const file = this.$refs.avatar.files[0];
                if (!file) return;
                this.selectedFileName = file.name;
                this.removeAvatar = false;
                if (this.imageUrl && this.imageUrl.startsWith('blob:')) URL.revokeObjectURL(this.imageUrl);
                this.imageUrl = URL.createObjectURL(file);
                this.isCropping = true;
                this.showPreviewModal = true;
                this.$nextTick(() => {
                    this.initCropper();
                });
            },
            isCameraOpen: false,
            videoStream: null,
            startCamera() {
                this.isCameraOpen = true;
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(stream => {
                            this.videoStream = stream;
                            this.$nextTick(() => {
                                if(this.$refs.videoElement) {
                                    this.$refs.videoElement.srcObject = stream;
                                }
                            });
                        })
                        .catch(err => {
                            console.error('Camera error:', err);
                            alert('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan pada browser Anda.');
                            this.closeCamera();
                        });
                } else {
                    alert('Browser Anda tidak mendukung fitur akses kamera.');
                    this.closeCamera();
                }
            },
            takePhoto() {
                const video = this.$refs.videoElement;
                if (!video) return;
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                
                canvas.toBlob((blob) => {
                    const file = new File([blob], 'webcam.jpg', { type: 'image/jpeg' });
                    
                    this.selectedFileName = file.name;
                    this.removeAvatar = false;
                    if (this.imageUrl && this.imageUrl.startsWith('blob:')) URL.revokeObjectURL(this.imageUrl);
                    this.imageUrl = URL.createObjectURL(file);
                    
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    this.$refs.avatar.files = dt.files;
                    
                    this.closeCamera();
                    
                    this.isCropping = true;
                    this.showPreviewModal = true;
                    this.$nextTick(() => {
                        this.initCropper();
                    });
                }, 'image/jpeg', 0.9);
            },
            closeCamera() {
                this.isCameraOpen = false;
                if (this.videoStream) {
                    this.videoStream.getTracks().forEach(track => track.stop());
                    this.videoStream = null;
                }
            },
            openViewModal() {
                if (this.photoPreview || (!this.removeAvatar && this.hasExistingAvatar)) {
                    this.isCropping = false;
                    this.imageUrl = this.photoPreview || (this.hasExistingAvatar ? '{{ asset('storage/' . $user->avatar) }}' : null);
                    this.showPreviewModal = true;
                } else {
                    this.$refs.avatar.click();
                }
            },
            initCropper() {
                if (this.cropper) {
                    this.cropper.destroy();
                }
                const image = this.$refs.previewImage;
                if (!image) return;
                this.cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    restore: false,
                    guides: false,
                    center: false,
                    highlight: false,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                    toggleDragModeOnDblclick: false,
                    background: false,
                });
            },
            resetFileInput() {
                this.$refs.avatar.value = null;
                if (this.imageUrl && this.imageUrl.startsWith('blob:')) URL.revokeObjectURL(this.imageUrl);
                this.imageUrl = null;
                this.photoPreview = null;
                this.selectedFileName = '';
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
            },
            rotateImage() {
                if (this.cropper) {
                    this.cropper.rotate(90);
                }
            },
            async savePreview() {
                if (!this.cropper) return;
                
                const canvas = this.cropper.getCroppedCanvas({
                    width: 500,
                    height: 500,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.9));
                if (!blob) return;
                
                this.isUploading = true;
                const formData = new FormData();
                formData.append('avatar', blob, 'avatar.jpg');
                formData.append('_token', '{{ csrf_token() }}');
                
                try {
                    const response = await fetch('{{ route('profile.avatar.update') }}', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        if (this.photoPreview) URL.revokeObjectURL(this.photoPreview);
                        this.photoPreview = data.avatar_url;
                        this.hasExistingAvatar = true;
                        
                        this.$dispatch('avatar-updated', data.avatar_url);
                        
                        this.showPreviewModal = false;
                        if (this.cropper) {
                            this.cropper.destroy();
                            this.cropper = null;
                        }
                        
                        this.toastMessage = 'Foto profil berhasil diperbarui';
                        this.showToast = true;
                        setTimeout(() => this.showToast = false, 3000);
                    } else {
                        alert('Gagal mengunggah foto.');
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    alert('Terjadi kesalahan saat mengunggah foto.');
                } finally {
                    this.isUploading = false;
                }
            },
            cancelPreview() {
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
                if (this.isCropping) {
                    this.$refs.avatar.value = null;
                }
                this.showPreviewModal = false;
            },
            async deleteAvatar() {
                const result = await Swal.fire({
                    title: 'Hapus Foto Profil?',
                    text: 'Foto profil Anda akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-5 py-2.5 font-bold',
                        cancelButton: 'rounded-xl px-5 py-2.5 font-bold'
                    }
                });
                
                if (!result.isConfirmed) return;
                
                this.isUploading = true;
                const formData = new FormData();
                formData.append('remove_avatar', '1');
                formData.append('_token', '{{ csrf_token() }}');
                
                try {
                    const response = await fetch('{{ route('profile.avatar.update') }}', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        this.removeAvatar = false;
                        this.hasExistingAvatar = false;
                        this.photoPreview = null;
                        this.imageUrl = null;
                        this.resetFileInput();
                        this.showPreviewModal = false;
                        
                        this.$dispatch('avatar-updated', null);
                        
                        this.toastMessage = 'Foto profil berhasil dihapus';
                        this.showToast = true;
                        setTimeout(() => this.showToast = false, 3000);
                    } else {
                        alert('Gagal menghapus foto.');
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    alert('Terjadi kesalahan saat menghapus foto.');
                } finally {
                    this.isUploading = false;
                }
            },
            async submitForm(event) {
                event.preventDefault();
                
                this.isUploading = true;
                const formData = new FormData(this.$refs.profileForm);
                
                try {
                    const response = await fetch(this.$refs.profileForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.toastMessage = data.message || 'Profil berhasil diperbarui';
                        this.showToast = true;
                        setTimeout(() => this.showToast = false, 3000);
                        
                        // Optional: you could dispatch an event here to update navbar name, etc.
                    } else {
                        if (data.errors) {
                            let msgs = [];
                            for(let k in data.errors) msgs.push(data.errors[k][0]);
                            alert('Gagal menyimpan:\n' + msgs.join('\n'));
                        } else {
                            alert(data.message || 'Terjadi kesalahan.');
                        }
                    }
                } catch (error) {
                    console.error('Save error:', error);
                    alert('Terjadi kesalahan koneksi.');
                } finally {
                    this.isUploading = false;
                }
            }
        }" x-ref="profileForm" @submit.prevent="submitForm">
        @csrf
        @method('patch')

        <div class="col-span-6 sm:col-span-4">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <input type="file" id="avatar" name="avatar" class="hidden"
                   accept="image/*"
                   x-ref="avatar"
                   @change="handleFileChange()" />

            <input type="hidden" name="remove_avatar" value="0" x-bind:value="removeAvatar ? 1 : 0">
            <canvas x-ref="cropCanvas" class="hidden"></canvas>

            <div class="mt-4 flex flex-col items-start gap-3">
                <div class="relative w-28 h-28 shrink-0">
                    <!-- Avatar Circle -->
                    <div class="w-full h-full rounded-full overflow-hidden border border-gray-200 shadow-sm bg-gray-100 flex items-center justify-center">
                        <button type="button" x-show="photoPreview || (!removeAvatar && hasExistingAvatar)" @click.prevent="openViewModal()" class="w-full h-full flex items-center justify-center focus:outline-none group">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover group-hover:opacity-90 transition">
                            </template>
                            <template x-if="!photoPreview && !removeAvatar && hasExistingAvatar">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover group-hover:opacity-90 transition">
                            </template>
                        </button>
                        <template x-if="removeAvatar || (!photoPreview && !hasExistingAvatar)">
                            <div class="w-full h-full flex items-center justify-center cursor-pointer hover:bg-gray-200 transition" @click.prevent="openViewModal()">
                                <span class="text-4xl font-bold text-gray-400">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        </template>
                    </div>

                    <!-- Camera Icon with Dropdown -->
                    <div class="absolute right-0 bottom-0" x-data="{ openMenu: false }">
                        <button type="button" aria-label="Edit foto profil" @click.prevent="openMenu = !openMenu" @click.outside="openMenu = false"
                                class="bg-purple-600 p-2.5 rounded-full ring-4 ring-white shadow-sm text-white hover:bg-purple-700 transition flex items-center justify-center z-10 relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="openMenu" x-transition.opacity.duration.200ms x-cloak class="absolute left-0 top-full mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-30 overflow-hidden">
                            <div class="py-1">
                                <button type="button" @click="startCamera(); openMenu = false" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Kamera
                                </button>
                                <button type="button" @click="$refs.avatar.click(); openMenu = false" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Galeri
                                </button>
                                <button type="button" x-show="photoPreview || (!removeAvatar && hasExistingAvatar)" @click="deleteAvatar(); openMenu = false" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <p x-show="removeAvatar" class="text-sm font-medium text-red-500" x-cloak>Foto akan dihapus saat menyimpan.</p>
            </div>
            
            <!-- Preview Modal -->
            <div x-show="showPreviewModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cancelPreview()"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl max-w-xl w-full mx-4 overflow-hidden border border-gray-100">
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-sm font-semibold text-gray-800">
                            <span class="text-base" x-text="isCropping ? ' Foto Profil' : 'Foto Profil'"></span>
                            <button type="button" aria-label="Rotasi" x-show="isCropping"
                                    @click.prevent="rotateImage()"
                                    class="bg-white p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition border border-gray-200 ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" aria-label="Hapus Foto" x-show="!isCropping && (photoPreview || (!removeAvatar && hasExistingAvatar))" @click.prevent="deleteAvatar()"
                                    class="bg-red-50 p-2 rounded-xl text-red-600 hover:bg-red-100 transition border border-red-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <button type="button" aria-label="Tutup preview" @click.prevent="cancelPreview()"
                                    class="bg-gray-50 p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition border border-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-4 flex flex-col items-center justify-center gap-4 bg-gray-50/50">
                        <div class="w-full flex items-center justify-center">
                            <!-- Preview Mode (clean image) -->
                            <div x-show="!isCropping" class="flex items-center justify-center">
                                <img :src="imageUrl" class="block max-w-full max-h-[60vh] rounded-2xl shadow-sm">
                            </div>

                            <!-- Crop Mode -->
                            <div x-show="isCropping" class="w-full h-[60vh] rounded-2xl flex items-center justify-center overflow-hidden">
                                <img :src="imageUrl" x-ref="previewImage" class="block max-w-full max-h-[60vh]">
                            </div>
                        </div>

                        <div class="w-full flex flex-col sm:flex-row justify-end gap-3" x-show="isCropping">
                            <button type="button" @click.prevent="cancelPreview()"
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition">
                                Batal
                            </button>
                            <button type="button"
                                    @click.prevent="savePreview()"
                                    :disabled="isUploading"
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-sm font-bold text-white shadow-md hover:from-blue-700 hover:to-purple-700 transition disabled:opacity-50">
                                <span x-text="isUploading ? 'Menyimpan...' : 'Simpan Foto'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Camera Modal -->
            <div x-show="isCameraOpen" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="closeCamera()"></div>

                <div class="relative bg-black rounded-3xl shadow-2xl max-w-xl w-full mx-4 overflow-hidden border border-gray-700">
                    <div class="p-4 border-b border-gray-800 flex items-center justify-between gap-2">
                        <div class="text-white font-semibold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Ambil Foto
                        </div>
                        <button type="button" aria-label="Tutup kamera" @click.prevent="closeCamera()" class="bg-gray-800 p-2 rounded-full text-gray-300 hover:text-white hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="relative w-full aspect-video bg-black flex items-center justify-center">
                        <video x-ref="videoElement" class="w-full h-full object-cover" playsinline autoplay></video>
                    </div>

                    <div class="p-6 flex items-center justify-center bg-gray-900">
                        <button type="button" @click.prevent="takePhoto()" class="bg-white p-1 rounded-full ring-4 ring-gray-600 hover:ring-purple-500 transition group focus:outline-none">
                            <div class="w-14 h-14 bg-white rounded-full group-hover:bg-gray-200 transition border-2 border-gray-300"></div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Toast Notification -->
            <div x-show="showToast" x-cloak x-transition.opacity.duration.300ms
                 class="fixed bottom-4 right-4 z-50 flex items-center gap-3 bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-xl">
                <div class="bg-green-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-sm font-medium" x-text="toastMessage"></span>
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

        <div class="flex items-center gap-4 pt-6 mt-4 border-t border-gray-100">
            <x-primary-button x-bind:disabled="isUploading" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 border-none px-8 py-2.5 rounded-2xl shadow-sm tracking-wide disabled:opacity-50 transition">
                <span x-text="isUploading ? 'Menyimpan...' : 'Simpan'"></span>
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>