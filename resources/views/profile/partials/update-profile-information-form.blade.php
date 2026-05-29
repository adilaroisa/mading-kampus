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

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" x-data="{ photoPreview: null, removeAvatar: false, showPreviewModal: false }" x-ref="profileForm">
        @csrf
        @method('patch')

        <div class="col-span-6 sm:col-span-4">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <input type="file" id="avatar" name="avatar" class="hidden"
                   accept="image/png, image/jpeg, image/gif"
                   x-ref="avatar"
                   @change="
                        const file = $refs.avatar.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                            removeAvatar = false;
                            showPreviewModal = true;
                            $dispatch('avatar-changed');
                        };
                        reader.readAsDataURL(file);
                   " />

            <input type="hidden" name="remove_avatar" value="0" x-bind:value="removeAvatar ? 1 : 0">

            <div class="mt-2 flex flex-col sm:flex-row sm:items-center sm:gap-5 gap-4">
                <div x-show="!photoPreview" class="relative w-20 h-20">
                    <div class="w-full h-full rounded-full overflow-hidden border-2 border-purple-100 shadow-sm bg-gray-100 flex items-center justify-center">
                        <button type="button" x-show="{{ $user->avatar ? 'true' : 'false' }}" @click="showPreviewModal = true" class="w-full h-full flex items-center justify-center focus:outline-none">
                            <template x-if="!removeAvatar && {{ $user->avatar ? 'true' : 'false' }}">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </template>
                            <span class="text-2xl font-bold text-purple-600" x-show="removeAvatar || {{ $user->avatar ? 'false' : 'true' }}">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </button>
                    </div>

                    <button type="button" aria-label="Edit foto profil" @click.prevent="$refs.avatar.click(); removeAvatar = false"
                            class="absolute -right-1 -bottom-1 bg-white p-1.5 rounded-full ring-2 ring-white shadow text-purple-600 hover:bg-purple-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9a1 1 0 01-.464.263l-4 1a1 1 0 01-1.213-1.213l1-4a1 1 0 01.263-.464l9.9-9.9a2 2 0 012.828 0zM15.121 4.95l-1.06 1.06L13 4.95l1.06-1.06 1.06 1.06z" />
                        </svg>
                    </button>

                    <!-- small delete icon removed; use modal delete instead -->
                </div>

                <div x-show="photoPreview" style="display: none;" class="relative w-20 h-20">
                    <button type="button" @click.prevent="showPreviewModal = true" class="absolute inset-0 w-full h-full flex items-center justify-center focus:outline-none">
                        <div class="w-full h-full rounded-full overflow-hidden border-2 border-purple-400 shadow-md">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </div>
                    </button>

                    <button type="button" aria-label="Edit foto profil" @click.prevent="$refs.avatar.click(); removeAvatar = false"
                            class="absolute -right-1 -bottom-1 bg-white p-1.5 rounded-full ring-2 ring-white shadow text-purple-600 hover:bg-purple-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9a1 1 0 01-.464.263l-4 1a1 1 0 01-1.213-1.213l1-4a1 1 0 01.263-.464l9.9-9.9a2 2 0 012.828 0zM15.121 4.95l-1.06 1.06L13 4.95l1.06-1.06 1.06 1.06z" />
                        </svg>
                    </button>

                    <button type="button" x-show="photoPreview"
                            @click.prevent="photoPreview = null; $refs.avatar.value = null; removeAvatar = false; $dispatch('avatar-changed')"
                            class="absolute -left-1 -bottom-1 bg-white p-1.5 rounded-full ring-2 ring-white shadow text-gray-600 hover:bg-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-10.536a.75.75 0 10-1.06-1.06L10 8.94 7.524 6.464a.75.75 0 10-1.06 1.06L8.94 10l-2.476 2.476a.75.75 0 101.06 1.06L10 11.06l2.476 2.476a.75.75 0 101.06-1.06L11.06 10l2.476-2.476z" clip-rule="evenodd" />
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
                <div class="absolute inset-0 bg-black/50" @click="showPreviewModal = false"></div>

                <div class="relative bg-white rounded-lg shadow-lg max-w-lg w-full mx-4">
                    <div class="p-3 flex justify-end gap-2">
                        <button type="button" aria-label="Hapus foto" x-show="photoPreview || {{ $user->avatar ? 'true' : 'false' }}" @click.prevent="removeAvatar = true; $refs.avatar.value = null; photoPreview = null; showPreviewModal = false; $dispatch('avatar-removed'); $nextTick(() => $refs.profileForm.submit())"
                                class="bg-white p-2 rounded-full text-red-500 hover:bg-red-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v1H2.5a.5.5 0 000 1H3v9a2 2 0 002 2h8a2 2 0 002-2V6h.5a.5.5 0 000-1H16V4a2 2 0 00-2-2H6zm3 5a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6A.5.5 0 019 7zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0v-6z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <button type="button" aria-label="Tutup preview" @click.prevent="showPreviewModal = false"
                                class="bg-white p-2 rounded-full text-gray-600 hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 flex items-center justify-center">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-48 h-48 md:w-80 md:h-80 object-cover">
                        </template>

                        <template x-if="!photoPreview">
                            <div class="flex items-center justify-center w-full">
                                <template x-if="!removeAvatar && {{ $user->avatar ? 'true' : 'false' }}">
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-48 h-48 md:w-80 md:h-80 object-cover">
                                </template>
                                <div x-show="removeAvatar || {{ $user->avatar ? 'false' : 'true' }}" class="w-48 h-48 md:w-80 md:h-80 rounded-md bg-gray-100 flex items-center justify-center text-4xl font-bold text-purple-600">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            </div>
                        </template>
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