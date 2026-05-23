<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi akun dan foto profil Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <input type="file" id="avatar" name="avatar" class="hidden"
                   x-ref="avatar"
                   @change="
                        photoName = $refs.avatar.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.avatar.files[0]);
                   " />

            <div class="mt-2 flex items-center gap-5">
                <div x-show="!photoPreview" class="w-20 h-20 rounded-full overflow-hidden border-2 border-purple-100 shadow-sm bg-gray-100 flex items-center justify-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-purple-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                
                <div x-show="photoPreview" style="display: none;" class="w-20 h-20 rounded-full overflow-hidden border-2 border-purple-400 shadow-md">
                    <img :src="photoPreview" class="w-full h-full object-cover">
                </div>

                <button type="button" 
                        class="px-4 py-2 border border-purple-200 rounded-2xl text-sm font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 transition duration-200"
                        @click.prevent="$refs.avatar.click()">
                    Pilih Foto Baru
                </button>
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